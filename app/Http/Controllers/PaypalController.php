<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use PayPal\Api\{
    Amount,
    Item,
    ItemList,
    Payer,
    Payment,
    PaymentExecution,
    RedirectUrls,
    Transaction
};

class PaypalController extends Controller
{
    private $_api_context;
    private array $paypal_configuration;

    public function __construct()
    {
        $this->paypal_configuration = config('paypal');

        $this->_api_context = new ApiContext(
            new OAuthTokenCredential($this->paypal_configuration['client_id'],
            $this->paypal_configuration['secret'])
        );
        $this->_api_context->setConfig($this->paypal_configuration['settings']);
    }

    public function index(Request $request, Student $student)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName('Subscription')
            ->setCurrency('EGP')
            ->setQuantity(1)
            ->setPrice($student->grade->mrs);

        $item_list = new ItemList();
        $item_list->setItems([$item]);

        $amount = new Amount();
        $amount->setCurrency('EGP')
            ->setTotal($student->grade->mrs);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Enter Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('students.pay.status', [
                'student' => $student->id
            ]))
            ->setCancelUrl(route('students.pay.status', [
                'student' => $student->id
            ]));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->_api_context);
        } catch (PayPalConnectionException $ex) {
            if (config('app.debug')) {
                session()->put('error', 'Connection timeout');
                return redirect()->route('students.show', [
                    'student' => $student->id
                ]);
            } else {
                session()->put('error', 'Some error occur, sorry for inconvenient');
                return redirect()->route('students.show', [
                    'student' => $student->id
                ]);
            }
        }

        foreach($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        session()->put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {
            return redirect()->away($redirect_url);
        }

        session()->put('error', 'Unknown error occurred');
        return redirect()->route('students.show', [
            'student' => $student->id
        ]);
    }

    public function status(Request $request, Student $student)
    {
        $payment_id = session()->get('paypal_payment_id');

        session()->forget('paypal_payment_id');
        if (
            empty($request->input('PayerID')) ||
            empty($request->input('token'))
        ) {
            session()->put('error', 'Payment failed');
            return redirect()->route('students.show', [
                'student' => $student->id
            ]);
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);

          if ($result->getState() == 'approved') {
            $student->update([
                'paid_at' => now()
            ]);

            session()->put('success', 'Payment success !!');
            return redirect()->route('students.show', [
                'student' => $student->id
            ]);
        }

        session()->put('error', 'Payment failed !!');
        return redirect()->route('students.show', [
            'student' => $student->id
        ]);
    }
}
