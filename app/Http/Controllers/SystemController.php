<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Price;
use App\Purchase;
use App\Sale;
use App\Stock;
use App\Timer;
use App\User;
use Carbon\Carbon;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Note\Note;
use ShiftechAfrica\CodeGenerator\ShiftCodeGenerator;

class SystemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * shopping cart
     * @return array
     */
    public static function shoppingCart(): array
    {
        $cart_contents = Cart::content();
        $subtotal = Cart::subtotal();

        return [$cart_contents, $subtotal];
    }


    /**
     * generate code
     * @return string
     */
    public static function generateCode(): string
    {
        return (new ShiftCodeGenerator)->generate();
    }


    /**
     * returns the elapsed time
     * @param $time
     * @return false|string
     */
    public static function elapsedTime($time)
    {
        return Carbon::parse($time)->diffForHumans();
    }

    /**
     * Write the system log files
     * @param array $data
     * @param string $channel
     * @param string $fileName
     * @throws Exception
     */
    public static function log(array $data, string $channel, string $fileName)
    {
        $file = storage_path('logs/' . $fileName . '.log');

        // finally, create a formatter
        $formatter = new JsonFormatter();

        // Create the log data
        $log = [
            'ip' => request()->getClientIp(),
            'data' => $data,
        ];
        // Create a handler
        $stream = new StreamHandler($file, Logger::INFO);
        $stream->setFormatter($formatter);

        // bind it to a logger object
        $securityLogger = new Logger($channel);
        $securityLogger->pushHandler($stream);
        $securityLogger->addInfo('info', $log);
    }

    /**
     * Timer
     * @return Builder|Model
     */
    public static function fetchLicense()
    {
        return Timer::query()->firstOrFail();
    }

    /**
     * Complete the purchase here
     * @param string $payment_mode_id
     * @param bool $credit
     * @return array|bool
     */
    public static function completePurchase(string $payment_mode_id, bool $credit = false)
    {
        $cartItems = self::shoppingCart()[0];
        $price_ids = [];

        if (count($cartItems)) {
            foreach ($cartItems as $shoppingCart) {
                if (!in_array($shoppingCart->id, $price_ids)) {
                    $price_ids[] = $shoppingCart->id;
                }
            }

            $prices = Price::query()->with('stock')->whereIn('id', $price_ids)->get();

            //create a purchase here
            $purchase = Purchase::query()->create([
                'user_id' => auth()->id(),
                'payment_mode_id' => $payment_mode_id,
                'purchaseNO' => self::generateCode(),
            ]);


            //create credit here
            if ($credit) {
                Credit::query()->create([
                    'purchase_id' => $purchase->id,
                    'name' => request()->input('name'),
                    'phoneNumber' => request()->input('phoneNumber'),
                ]);
            }

            foreach ($cartItems as $cartItem) {
                foreach ($prices as $price) {
                    if ($price->id == $cartItem->id) {
                        $stock = $price->stock()->where('past', false)->where('counter', '>', 0)->orderBy('created_at', 'asc')->first();
                        if ($cartItem->price > 0 && $stock)
                            if ($cartItem->qty <= $stock->counter) {
                                $qty = $cartItem->qty;
                                self::completeStock($stock, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);
                            } else {
                                $qty = $stock->counter;
                                self::completeStock($stock, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);

                                //fetch new stock
                                $qty = ($cartItem->qty - $qty);
                                $stockTwo = $price->stock()->where('past', false)->where('counter', '>', 0)->orderBy('created_at', 'asc')->first();
                                if ($qty > 0 && $stockTwo)
                                    if ($qty <= $stockTwo->counter) {
                                        self::completeStock($stockTwo, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);
                                    } else {
                                        $qty = $stockTwo->counter;
                                        self::completeStock($stockTwo, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);

                                        //fetch new stock
                                        $qty = ($cartItem->qty - $qty);
                                        $stockThree = $price->stock()->where('past', false)->where('counter', '>', 0)->orderBy('created_at', 'asc')->first();
                                        if ($qty > 0 && $stockThree)
                                            if ($qty <= $stockThree->counter) {
                                                self::completeStock($stockThree, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);
                                            } else {
                                                $qty = $stockThree->counter;
                                                self::completeStock($stockThree, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);

                                                //fetch new stock
                                                $qty = ($cartItem->qty - $qty);
                                                $stockFour = $price->stock()->where('past', false)->where('counter', '>', 0)->orderBy('created_at', 'asc')->first();
                                                if ($qty > 0 && $stockFour)
                                                    if ($qty <= $stockFour->counter) {
                                                        self::completeStock($stockFour, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);
                                                    } else {
                                                        $qty = $stockFour->counter;
                                                        self::completeStock($stockFour, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);

                                                        //fetch new stock
                                                        $qty = ($cartItem->qty - $qty);
                                                        $stockFive = $price->stock()->where('past', false)->where('counter', '>', 0)->orderBy('created_at', 'asc')->first();
                                                        if ($qty > 0 && $stockFive)
                                                            if ($qty <= $stockFive->counter) {
                                                                self::completeStock($stockFive, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);
                                                            } else {
                                                                $qty = $stockFive->counter;
                                                                self::completeStock($stockFive, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);

                                                                //fetch new stock
                                                                $qty = ($cartItem->qty - $qty);
                                                                $stockSix = $price->stock()->where('past', false)->where('counter', '>', 0)->orderBy('created_at', 'asc')->first();
                                                                if ($qty > 0 && $stockSix)
                                                                    if ($qty <= $stockSix->counter) {
                                                                        self::completeStock($stockSix, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);
                                                                    } else {
                                                                        $qty = $stockSix->counter;
                                                                        self::completeStock($stockSix, $purchase, $payment_mode_id, $qty, $cartItem->price, $credit);
                                                                    }
                                                            }
                                                    }
                                            }
                                    }
                            }

                        // do a notification here if the stock id below the one set
                        if ($price->stock->sum('counter') <= $price->lowest) {
                            foreach (User::query()->where('superAdmin', true)->get() as $user)
                                Note::createSystemNotification(
                                    $user->id,
                                    User::class,
                                    $price->itemName . ' Stock Notification',
                                    'The stock remaining is only ' . $price->stock->sum('counter') . ' items(s).'
                                );
                        }
                    }
                }
            }

            return [true, $purchase->purchaseNO];
        }

        return [true, self::generateCode()];
    }

    /**
     * Complete purchase process here
     * @param object $stock
     * @param object $purchase
     * @param string $payment_mode_id
     * @param float $qty
     * @param float $price
     * @param bool $credit
     */
    private static function completeStock(object $stock, object $purchase, string $payment_mode_id, float $qty, float $price, bool $credit)
    {
        //Update the stock
        $stock->itemSQuantity += $qty;
        $stock->counter -= $qty;
        $stock->itemTSBPrice += ($qty * $price);
        $stock->update();

        //Update the revenue
        $newStock = Stock::query()->findOrFail($stock->id);
        $newStock->itemRevenue = ($newStock->itemTSBPrice - $newStock->itemTBPrice);
        $newStock->update();

        //Fetch sale
        $sale = Sale::query()->where('purchase_id', $purchase->id)->where('stock_id', $stock->id)->first();
        if (!$sale) {
            //Create Sale
            Sale::query()->create([
                'user_id' => auth()->id(),
                'stock_id' => $newStock->id,
                'purchase_id' => $purchase->id,
                'price_id' => $newStock->price_id,
                'payment_mode_id' => $payment_mode_id,
                'price' => $price,
                'qty' => $qty,
                'total' => ($qty * $price),
            ]);
        } else {
            $sale->qty += $qty;
            $sale->total += ($qty * $price);
            $sale->update();
        }


        //update the purchase here
        $purchase->qty += $qty;
        $purchase->price += ($qty * $price);
        $purchase->paid = true;
        $purchase->update();

        // update the credit here
        if ($credit) {
            $creditQuery = Credit::query()->where('purchase_id', $purchase->id)->first();
            $creditQuery->qty += $qty;
            $creditQuery->price += ($qty * $price);
            $creditQuery->balance += ($qty * $price);
            $creditQuery->update();

            //update purchase as unpaid
            $purchase->update([
                'paid' => false,
            ]);
        }
    }

    /**
     * Get the tax rate here
     * @param float $amount
     * @param bool $tax
     * @return float|int
     */
    public static function taxRate(float $amount, bool $tax = true)
    {
        if ($tax)
            return ($amount * (env('TAX_RATE') / 100));
        return ($amount * (env('NO_TAX_RATE') / 100));
    }
}
