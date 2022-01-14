<?php

namespace App\Http\Controllers;

use App\Credit;
use App\CreditPayment;
use App\Exports\ItemReport;
use App\Exports\SaleReport;
use App\Exports\SupplierReport;
use App\Http\Requests\ArrearPaymentRequest;
use App\Http\Requests\AssignSupplierRequest;
use App\Http\Requests\CartRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CreditPaymentRequest;
use App\Http\Requests\CreditPurchaseRequest;
use App\Http\Requests\NewUserRequest;
use App\Http\Requests\PriceRequest;
use App\Http\Requests\PriceSelectRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\ReportRequest;
use App\Http\Requests\RequestID;
use App\Http\Requests\StockRequest;
use App\Http\Requests\SupplierRequest;
use App\Http\Requests\UpdatePriceRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\PaymentMode;
use App\Price;
use App\Purchase;
use App\Sale;
use App\Stock;
use App\Supplier;
use App\SupplierArrear;
use App\SupplierPayment;
use App\Supply;
use App\User;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Note\Note;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('blocked');
        $this->middleware('pos');
        $this->middleware('sharedAccess')->only('newSupplierPage', 'addSupplier', 'viewSupplier', 'viewSupplierItems', 'editSupplier', 'updateSupplier', 'assignSupplierPage', 'assignSupplier', 'removeSupplier', 'supplierPendingArrears', 'supplierClearedArrears', 'arrearsPaymentPage', 'payArrear', 'viewArrearPayment', 'creditPaymentStatements', 'payCreditPurchase', 'creditPurchasePayment', 'clearedCredits', 'pendingCredits', 'allCreditPurchases', 'generateReportPage', 'generateReport', 'index');
        $this->middleware('superAdminAccess')->only('addUserPage', 'addUser', 'viewUsers', 'blockUser', 'pricePage', 'pricing', 'viewPrices', 'editPrice', 'updatePricing', 'viewStock', 'markStockAsPast', 'viewPastSock');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('home', [
            'sales' => count(Sale::all()),
            'users' => count(User::all()),
            'items' => count(Price::all()),
            'stocks' => count(Stock::all()),
            'sells' => Sale::query()->with('user', 'purchase', 'payment_mode', 'stock')->latest()->limit(12)->get(),
        ]);
    }

    /**
     * profile here
     * @return Factory|View
     */
    public function profile()
    {
        return view('user.account.profile');
    }

    /**
     * user password page
     * @return Factory|View
     */
    public function passwordPage()
    {
        return view('user.account.change_password');
    }

    /**
     * change admin password here
     * @param ChangePasswordRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        // Extract the request data.
        $password = $request->currentPassword;
        $newPassword = $request->newPassword;
        $confirmPassword = $request->confirmPassword;

        // Get the current password
        $currentPassword = auth()->user()->password;
        // Check if current password matches the sent password.
        if (!Hash::check($password, $currentPassword)) {
            return redirect()->back()->with('error', 'The entered password does not match our records.');
        }
        // Check if new password matches current password.
        if (strcmp($newPassword, $password) === 0) {
            return redirect()->back()->with('error', 'New password cannot be same as your current password.');
        }
        // Check if the new password matches the confirmation password.
        if (strcmp($newPassword, $confirmPassword) !== 0) {
            return redirect()->back()->with('error', 'The confirmation password does not match.');
        }

        // Get the current auth user and update their password.
        $user = auth()->user();
        $user->password = bcrypt($newPassword);
        $user->update();

        //log this session
        Note::createSystemNotification($user->id, User::class, 'Password Update', 'Your account password has been updated');

        return redirect()->back()->with('success', 'You have successfully changed your password.');
    }


    /**
     * pricing here
     * @return Factory|View
     */
    public function pricePage()
    {
        return view('user.pricing.pricing');
    }

    /**
     * pricing
     * @param PriceRequest $request
     * @return RedirectResponse
     */
    public function pricing(PriceRequest $request)
    {
        try {
            $newPrice = Price::query()->create($request->all());
            if ($newPrice) {
                return redirect()->back()->with('success', $request->itemName . ' added successfully');
            }
            return redirect()->back()->with('error', 'Failed.');
        } catch (Exception $exception) {
            return redirect()->route('home');
        }
    }

    /**
     * view prices here
     * @return Factory|View
     */
    public function viewPrices()
    {
        return view('user.pricing.prices', [
            'prices' => Price::query()->with('stock', 'supply', 'sale')->orderByDesc('updated_at')->paginate(env('MIN_PAGINATION')),
        ]);
    }

    /**
     * Edit price
     * @param string $id
     * @return Factory|RedirectResponse|View
     */
    public function editPrice(string $id)
    {
        try {
            $price = Price::query()->findOrFail($id);
            return view('user.pricing.edit', [
                'price' => $price,
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Error occurred');
        }
    }

    /**
     * update pricing here
     * @param UpdatePriceRequest $request
     * @return RedirectResponse
     */
    public function updatePricing(UpdatePriceRequest $request)
    {
        try {
            $price = Price::query()->findOrFail($request->price_id);
            $price->update([
                'itemName' => $request->itemName,
                'itemPrice' => $request->itemPrice,
                'itemBPrice' => $request->itemBPrice,
                'lowest' => $request->lowest,
            ]);

            return redirect()->back()->with('success', $price->itemName . ' details updated.');
        } catch (Exception $exception) {
            return redirect()->route('home');
        }
    }

    /**
     * View supplier
     * @return Factory|View
     */
    public function newSupplierPage()
    {
        return view('user.supplier.new', [
            'prices' => Price::query()->orderByDesc('updated_at')->get(),
        ]);
    }

    /**
     * add new suppliers
     * @param SupplierRequest $request
     * @return RedirectResponse
     */
    public function addSupplier(SupplierRequest $request)
    {
        $supplier = Supplier::query()->create($request->all());

        if ($supplier) {
            return redirect()->back()->with('success', $supplier->name . ' added successfully');
        }
        return redirect()->back()->with('error', 'Failed.');
    }

    /**
     * assign supplier
     * @return Factory|View
     */
    public function assignSupplierPage()
    {
        return view('user.supplier.assign', [
            'suppliers' => Supplier::query()->orderByDesc('updated_at')->get(),
            'prices' => Price::query()->orderByDesc('itemName')->get(),
        ]);
    }

    /**
     * assign supplier here
     * @param AssignSupplierRequest $request
     * @return RedirectResponse
     */
    public function assignSupplier(AssignSupplierRequest $request)
    {
        $supplier = Supplier::query()->findOrFail($request->supplier_id);
        $supplies = Supply::query();
        $check = $supplies->with('price')->where('price_id', $request->price_id)->where('supplier_id', $request->supplier_id)->first();

        if ($check)
            return redirect()->back()->with('warning', $supplier->name . ' is already one of the suppliers for ' . $check->price->itemName . ' item.');

        $supply = $supplies->create($request->all());
        if ($supply)
            return redirect()->back()->with('success', $supplier->name . ' assigned successfully');
        return redirect()->back()->with('error', 'Failed.');
    }

    /**
     * Remove supplier
     * @param string $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function removeSupplier(string $id)
    {
        try {
            $supply = Supply::query()->with('supplier', 'price')->findOrFail($id);
            if ($supply->delete())
                return redirect()->back()->with('success', $supply->supplier->name . ' removed as supplier for ' . $supply->price->itemName . ' item.');
            return redirect()->back()->with('error', 'Failed.');
        } catch (Exception $exception) {
            return redirect()->route('home');
        }
    }

    /**
     * view suppliers here
     * @return Factory|View
     */
    public function viewSupplier()
    {
        return view('user.supplier.view', [
            'suppliers' => Supplier::query()->with('supply')->orderByDesc('created_at')->paginate(env('MIN_PAGINATION')),
        ]);
    }

    /**
     * view supplier items
     * @param string $id
     * @return Factory|View
     */
    public function viewSupplierItems(string $id)
    {
        return view('user.supplier.prices', [
            'supplies' => Supply::query()->with('price', 'supplier')->whereIn('supplier_id', [$id])->orderByDesc('updated_at')->paginate(env('MIN_PAGINATION')),
        ]);
    }

    /**
     * edit supplier details
     * @param string $id
     * @return Factory|RedirectResponse|View
     */
    public function editSupplier(string $id)
    {
        try {
            $supplier = Supplier::query()->findOrFail($id);

            return view('user.supplier.edit', [
                'supplier' => $supplier,
                'prices' => Price::query()->orderByDesc('updated_at')->get(),
            ]);
        } catch (Exception $exception) {
            return redirect()->route('home');
        }
    }

    /**
     * Update supplier details
     * @param UpdateSupplierRequest $request
     * @return RedirectResponse
     */
    public function updateSupplier(UpdateSupplierRequest $request)
    {
        $supplier = Supplier::query()->findOrFail($request->supplier_id);
        $supplier->update($request->all());
        return redirect()->back()->with('success', 'Supplier details updated successfully.');
    }

    /**
     * select stock to add here
     * @return Factory|View
     */
    public function stockItemPage()
    {
        return \view('user.stock.select-price', [
            'prices' => Price::query()->orderByDesc('itemName')->get(),
        ]);
    }

    /**
     * Proceed to the chosen item
     * @param PriceSelectRequest $request
     * @return Factory|RedirectResponse|View
     */
    public function stockItem(PriceSelectRequest $request)
    {
        $price = Price::query()->with('supply')->findOrFail($request->price_id);
        if (count($price->supply))
            return view('user.stock.new', [
                'price' => $price,
                'suppliers' => $price->supply,
            ]);

        return redirect()->route('assign.supplier')->with('warning', 'Please assign a supplier first to ' . $price->itemName . ' item.');
    }

    /**
     * New Stock
     * @param StockRequest $request
     * @return RedirectResponse
     */
    public function stock(StockRequest $request)
    {
        $stock = Stock::query()->create([
            'price_id' => $request->price_id,
            'SKU' => SystemController::generateCode(),
            'itemBPrice' => $request->itemBPrice,
            'itemBQuantity' => $request->itemBQuantity,
            'counter' => $request->itemBQuantity,
            'itemTBPrice' => ($request->itemBQuantity * $request->itemBPrice),
            'itemRevenue' => 0 - ($request->itemBQuantity * $request->itemBPrice),
        ]);

        //supplier arrears
        $supplierArrears = SupplierArrear::query()->create([
            'stock_id' => $stock->id,
            'supplier_id' => $request->supplier_id,
            'amount' => $request->payment,
            'balance' => $request->payment,
        ]);

        if ($supplierArrears && $stock)
            return redirect()->back()->with('success', 'New Stock added successfully.');
        return redirect()->back()->with('error', 'Failed.');
    }

    /**
     * ----------
     * view stock
     * ----------
     * @return Factory|View
     */
    public function viewStock()
    {
        return view('user.stock.view', [
            'stocks' => Stock::query()->with('price')->where('past', false)->orderByDesc('updated_at')->paginate(env('MAX_PAGINATION')),
        ]);
    }

    /**
     * ----------
     * view stock
     * ----------
     * @return Factory|View
     */
    public function viewPastSock()
    {
        return view('user.stock.past', [
            'stocks' => Stock::query()->with('price')->where('past', true)->orderByDesc('updated_at')->paginate(env('MAX_PAGINATION')),
        ]);
    }

    /**
     * Mark stock as past stock
     * @param string $id
     * @return RedirectResponse
     */
    public function markStockAsPast(string $id)
    {
        $stock = Stock::query()->findOrFail($id);
        $stock->update([
            'past' => true,
        ]);

        return redirect()->back()->with('success', $stock->SKU . ' stock marked as a past stock. Please check it at the past stock.');
    }

    /**
     * Sales here
     * @return Factory|View
     * @throws Exception
     */
    public function sales()
    {
        return view('user.sales.sales', [
            'cartItems' => count(SystemController::shoppingCart()[0]),
            'subtotal' => SystemController::shoppingCart()[1],
            'prices' => Price::query()->with('stock')->inRandomOrder()->paginate(env('HIGHER_PAGINATION')),
        ]);
    }

    /**
     * Process sell here
     * @param CartRequest $request
     * @return RedirectResponse
     */
    public function sell(CartRequest $request)
    {
        // Add the items to the cart
        Cart::add([
            [
                'id' => $request->price_id,
                'name' => $request->itemName,
                'qty' => $request->qty,
                'price' => $request->price,
            ],
        ]);

        toastr()->success('Cart Items Added');
        return redirect()->back()->with('success', $request->itemName . ' added to cart successfully.');
    }

    /**
     * View cart here
     * @return Factory|RedirectResponse|View
     */
    public function viewCart()
    {
        $cartItems = SystemController::shoppingCart()[0];
        $price_ids = [];

        if (count($cartItems)) {
            foreach ($cartItems as $shoppingCart) {
                if (!in_array($shoppingCart->id, $price_ids)) {
                    $price_ids[] = $shoppingCart->id;
                }
            }

            $prices = Price::query()->with('stock')->whereIn('id', $price_ids)->get();

            //validate the available stock
            foreach ($cartItems as $cartItem) {
                foreach ($prices as $price) {
                    if ($cartItem->id == $price->id) {
                        if ($cartItem->qty > ($price->stock->sum('itemBQuantity') - $price->stock->sum('itemSQuantity'))) {
                            Cart::update($cartItem->rowId, ($price->stock->sum('itemBQuantity') - $price->stock->sum('itemSQuantity')));
                            Note::createSystemNotification(auth()->id(), User::class, 'Stock Notification', $price->itemName . ' stock is only remaining ' . number_format(($price->stock->sum('itemBQuantity') - $price->stock->sum('itemSQuantity'))));
                        }
                    }
                }
            }


            return view('user.sales.view-cart', [
                'modes' => PaymentMode::query()->inRandomOrder()->get(),
                'cartItems' => $cartItems,
                'subtotal' => (new SystemController)->shoppingCart()[1],
                'prices' => $prices,
            ]);
        }

        return redirect()->route('sales');
    }

    /**
     * Update cart
     * @param CartUpdateRequest $request
     * @return RedirectResponse
     */
    public function updateCart(CartUpdateRequest $request)
    {
        $access = 0;
        //check
        if (count($request->rowId) > 0 && count($request->qty)) {
            foreach ($request->rowId as $rowId) {
                //update the cart
                Cart::update($rowId, $request->qty[$access]); // Will update the quantity
                $access++;
            }
            toastr()->success('Cart updated.', env('APP_NAME') . ' Shopping Cart');
        } else {
            toastr()->error('Cart failed to update.', env('APP_NAME') . ' Shopping Cart');
        }

        return redirect()->back();
    }

    /**
     * delete item from the cart
     * @param string $rowId
     * @return RedirectResponse
     */
    public function deleteItemCart(string $rowId)
    {
        $item = Cart::get($rowId);
        $check = Cart::remove($rowId);
        if ($check == null) {
            toastr()->success($item->name . ' removed successfully from your cart.', env('APP_NAME') . ' Shopping Cart');
            return redirect()->back()->with('success', $item->name . ' removed from cart.');
        }
        toastr()->error('Failed to remove ' . $item->name . ' from your cart.', env('APP_NAME') . ' Shopping Cart');
        return redirect()->back()->with('error', $item->name . ' failed to be removed from the cart.');
    }

    /**
     * Clear cart
     * @return RedirectResponse
     */
    public function clearCart()
    {
        Cart::destroy();
        toastr()->success('You have emptied your cart.');
        return redirect()->back()->with('success', 'Cart has been cleared.');
    }

    /**
     * Complete the purchase here
     * @param PurchaseRequest $request
     * @return Factory|RedirectResponse|View
     */
    public function completePurchase(PurchaseRequest $request)
    {
        try {
            $mode = PaymentMode::query()->where('mode', env('MODE_CREDIT'))->first();

            if ($request->payment_mode_id == $mode->id) {
                return view('user.sales.credit', [
                    'payment_mode_id' => $request->payment_mode_id,
                ]);
            }

            $response = SystemController::completePurchase($request->payment_mode_id);
            if ($response[0]) {
                Cart::destroy();
                Note::createSystemNotification(auth()->id(), User::class, 'Purchase', 'New purchase completed.');
                toastr()->success('The purchase has been completed.');

                //fetch purchase
                $purchase = Purchase::query()->with('sale')->where('purchaseNO', $response[1])->first();
                if (!$purchase)
                    return redirect()->route('sales');

                return view('user.pdf.dom-purchase', [
                    'purchase' => $purchase,
                    'prices' => Price::query()->inRandomOrder()->get(),
                ]);
            }
            return redirect()->back()->with('error', 'Purchase failed.');
        } catch (Exception $exception) {
            return redirect()->route('sales')->with('warning', 'Purchase completed with exception.');
        }
    }

    /**
     * Complete credit purchase
     * @param CreditPurchaseRequest $request
     * @return Factory|RedirectResponse|View
     */
    public function creditPurchase(CreditPurchaseRequest $request)
    {
        try {
            $response = SystemController::completePurchase($request->payment_mode_id, true);
            if ($response[0]) {
                Cart::destroy();
                Note::createSystemNotification(auth()->id(), User::class, 'Purchase', 'Credit purchase completed.');

                toastr()->success('The credit purchase has been completed.');

                //fetch purchase
                $purchase = Purchase::query()->with('sale')->where('purchaseNO', $response[1])->first();
                if (!$purchase)
                    return redirect()->route('sales');

                return view('user.pdf.dom-purchase', [
                    'purchase' => $purchase,
                    'prices' => Price::query()->inRandomOrder()->get(),
                ]);
            }
            return redirect()->route('view.cart')->with('error', 'Credit Purchase failed.');
        } catch (Exception $exception) {
            return redirect()->route('sales')->with('warning', 'Purchase completed with exception.');
        }
    }

    /**
     * View Supply cleared arrears
     * @return Factory|View
     */
    public function supplierClearedArrears()
    {
        return \view('user.supplier.cleared-arrears', [
            'supplies' => SupplierArrear::query()->with('stock', 'supplier')->where('cleared', true)->orderByDesc('updated_at')->paginate(env('MAX_PAGINATION')),
        ]);
    }

    /**
     * View Supply pending arrears
     * @return Factory|View
     */
    public function supplierPendingArrears()
    {
        return \view('user.supplier.pending-arrears', [
            'supplies' => SupplierArrear::query()->with('stock', 'supplier')->where('cleared', false)->orderByDesc('updated_at')->paginate(env('MAX_PAGINATION')),
        ]);
    }

    /**
     * Arrears payment page
     * @param string $id
     * @return Factory|RedirectResponse|View
     */
    public function arrearsPaymentPage(string $id)
    {
        try {
            return \view('user.supplier.arrear-payment', [
                'arrear' => SupplierArrear::query()->with('supplier', 'stock', 'supplier_payment')->findOrFail($id),
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Failed');
        }
    }

    /**
     * Pay arrear here
     * @param ArrearPaymentRequest $request
     * @return RedirectResponse
     */
    public function payArrears(ArrearPaymentRequest $request)
    {
        $arrears = SupplierArrear::query()->findOrFail($request->supplier_arrear_id);
        $arrears->paid += $request->payment;
        $arrears->save();

        // refresh new arrears
        $newArrears = SupplierArrear::query()->with('supplier', 'stock')->findOrFail($request->supplier_arrear_id);
        $newArrears->balance -= ($newArrears->amount - $newArrears->paid);
        $newArrears->save();

        //create payment statements
        SupplierPayment::query()->create([
            'user_id' => auth()->id(),
            'supplier_arrear_id' => $newArrears->id,
            'invoiceNumber' => SystemController::generateCode(),
            'amount' => $request->payment,
        ]);

        // assign balance
        $balance = ($newArrears->amount - $newArrears->paid);

        //check if balance is cleared
        if ($balance <= 0) {
            $newArrears->update([
                'cleared' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Stock Number ' . $newArrears->stock->SKU . ' has been paid to ' . $newArrears->supplier->name);
    }

    /**
     * View all arrears payment
     * @param string $id
     * @return Factory|View
     */
    public function viewArrearPayment(string $id)
    {
        return \view('user.supplier.payment', [
            'payments' => SupplierPayment::query()->with('user', 'supplier_arrear')->whereIn('supplier_arrear_id', [$id])->paginate(env('MAX_PAGINATION')),
        ]);
    }

    /**
     * Print purchase here
     * @param string $purchaseNO
     * @return Factory|View
     */
    public function printPurchase(string $purchaseNO)
    {
        //fetch purchase
        $purchase = Purchase::query()->with('sale')->where('purchaseNO', $purchaseNO)->first();
        return view('user.pdf.purchases', [
            'purchase' => $purchase,
            'prices' => Price::query()->inRandomOrder()->get(),
        ]);
    }

    /**
     * Print purchase here with tax
     * @param string $purchaseNO
     * @return Factory|View
     */
    public function printPurchaseWithTax(string $purchaseNO)
    {
        //fetch purchase
        $purchase = Purchase::query()->with('sale')->where('purchaseNO', $purchaseNO)->first();
        return view('user.pdf.tax', [
            'purchase' => $purchase,
            'prices' => Price::query()->inRandomOrder()->get(),
        ]);
    }

    /**
     * Today sells
     * @return Factory|View
     */
    public function todaySells()
    {
        return \view('user.sells.daily', [
            'sells' => Sale::query()->with('user', 'purchase', 'payment_mode', 'stock')->whereDate('created_at', today())->orderByDesc('created_at')->paginate(env('MAX_PAGINATION')),
        ]);
    }

    /**
     * Today sells
     * @return Factory|View
     */
    public function allSells()
    {
        return \view('user.sells.all', [
            'sells' => Sale::query()->with('user', 'purchase', 'payment_mode', 'stock')->orderByDesc('created_at')->paginate(env('HIGHER_PAGINATION')),
        ]);
    }

    /**
     * Get today purchases
     * @return Factory|View
     */
    public function todayPurchases()
    {
        return \view('user.purchases.daily', [
            'purchases' => Purchase::query()->with('user', 'sale', 'payment_mode')->whereDate('created_at', today())->orderByDesc('created_at')->paginate(env('MAX_PAGINATION')),
        ]);
    }

    /**
     * Get all purchases
     * @return Factory|View
     */
    public function allPurchases()
    {
        return \view('user.purchases.all', [
            'purchases' => Purchase::query()->with('user', 'sale', 'payment_mode')->orderByDesc('created_at')->paginate(env('MAX_PAGINATION')),
        ]);
    }

    /**
     * Purchase items
     * @param string $id
     * @return Factory|View
     */
    public function purchaseItems(string $id)
    {
        return \view('user.purchases.items', [
            'sells' => Sale::query()->with('user', 'purchase', 'payment_mode', 'stock')->whereIn('purchase_id', [$id])->orderByDesc('created_at')->paginate(env('MAX_PAGINATION')),
        ]);
    }

    /**
     * Print purchase receipt
     * @param string $purchaseNO
     * @return Factory|RedirectResponse|View
     */
    public function purchaseReceipt(string $purchaseNO)
    {
        //fetch purchase
        $purchase = Purchase::query()->with('sale')->where('purchaseNO', $purchaseNO)->first();
        if (!$purchase)
            return redirect()->route('sales');

        return view('user.pdf.dom-purchase', [
            'purchase' => $purchase,
            'prices' => Price::query()->inRandomOrder()->get(),
        ]);
    }

    /**
     * view all cleared credit purchases here
     * @return Factory|View
     */
    public function clearedCredits()
    {
        return \view('user.purchases.credit.cleared', [
            'purchases' => Credit::query()->with('purchase', 'credit_payment')->where('cleared', true)->orderByDesc('updated_at')
                ->paginate(env('HIGHER_PAGINATION')),
        ]);
    }

    /**
     * view all pending credit purchases here
     * @return Factory|View
     */
    public function pendingCredits()
    {
        return \view('user.purchases.credit.pending', [
            'purchases' => Credit::query()->with('purchase', 'credit_payment')->where('cleared', false)->orderByDesc('updated_at')
                ->paginate(env('HIGHER_PAGINATION')),
        ]);
    }

    /**
     * view all credit purchases here
     * @return Factory|View
     */
    public function allCreditPurchases()
    {
        return \view('user.purchases.credit.all-view', [
            'purchases' => Credit::query()->with('purchase', 'credit_payment')->orderByDesc('updated_at')
                ->paginate(env('HIGHER_PAGINATION')),
        ]);
    }

    /**
     * Credit purchase payment
     * @param string $id
     * @return Factory|View
     */
    public function creditPurchasePayment(string $id)
    {
        return \view('user.purchases.credit.payment', [
            'purchase' => Credit::query()->with('purchase')->findOrFail($id),
        ]);
    }

    /**
     * Pay credit purchase here
     * @param CreditPaymentRequest $request
     * @return RedirectResponse
     */
    public function payCreditPurchase(CreditPaymentRequest $request)
    {
        $credit = Credit::query()->findOrFail($request->credit_id);
        $credit->paid += $request->payment;
        $credit->update();

        //refresh the credit
        $newCredit = Credit::query()->with('purchase')->findOrFail($request->credit_id);
        $newCredit->balance = ($newCredit->price - $newCredit->paid);
        $newCredit->update();

        //write payment statements
        CreditPayment::query()->create([
            'user_id' => auth()->id(),
            'credit_id' => $credit->id,
            'invoiceNumber' => SystemController::generateCode(),
            'amount' => $request->payment,
        ]);

        //update credit as cleared also the purchase
        if ($newCredit->balance <= 0) {
            $newCredit->update([
                'cleared' => true,
            ]);

            $newCredit->purchase->update([
                'paid' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Payment has been made.');
    }

    /**
     * Credit payment
     * @param string $id
     * @return Factory|View
     */
    public function creditPaymentStatements(string $id)
    {
        return \view('user.purchases.credit.payments', [
            'payments' => CreditPayment::query()->with('credit', 'user')->whereIn('credit_id', [$id])->orderByDesc('created_at')->paginate(env('MAX_PAGINATION')),
        ]);
    }

    /**
     * Add users here
     * @return Factory|View
     */
    public function addUserPage()
    {
        return \view('user.system.add-user');
    }

    /**
     * Add users here
     * @param NewUserRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function addUser(NewUserRequest $request)
    {
        $pin = random_int(10000, 50000);
        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'pin' => $pin,
            'password' => bcrypt($request->phoneNumber),
        ]);

        if ($request->level === 'admin') {
            $user->update([
                'admin' => true,
            ]);
        }

        //notification
        Note::createSystemNotification($user->id, User::class, 'System Credentials', 'Your account pin is ' . $pin . ' and account password is ' . $request->phoneNumber);

        return redirect()->back()->with('success', $user->name . ' has been created successfully and account password is ' . $request->phoneNumber);
    }

    /**
     * View all Users here
     * @return Factory|View
     */
    public function viewUsers()
    {
        return \view('user.system.view', [
            'users' => User::query()->orderByDesc('updated_at')->paginate(env('MAX_PAGINATION')),
        ]);
    }

    /**
     * Block user here
     * @return RedirectResponse
     */
    public function blockUser()
    {
        $client = (new User())->newQuery()->where('id', request()->input('id'))->first();

        if ($client->blocked) {
            //update status
            $client->blocked = false;
            $client->update();
            $status = "un-blocked";
        } else {
            //update status
            $client->blocked = true;
            $client->update();
            $status = "blocked";
        }

        //email the new admin password
        $title = 'System Access';
        $message = 'Hello ' . $client->name . ' you have been ' . $status . ' from the system.';
        Note::createSystemNotification($client->id, User::class, $title, $message);

        return redirect()->back()->with('success', 'Successfully ' . $status . ' ' . $client->name . ' from the system.');
    }

    /**
     * admin mails/notifications
     * @return Factory|View
     */
    public function latestMailBox()
    {
        return view('user.mailbox.latestMail', [
            'latestMails' => Note::latestNotifications('web'),
        ]);
    }

    /**
     * read mail
     * @param string $notification_id
     * @return Factory|View
     */
    public function readMailBox(string $notification_id)
    {
        return view('user.mailbox.readMail', [
            'fetchMail' => Note::readNotification($notification_id, 'web'),
        ]);
    }

    /**
     * admin delete single mail
     * @param RequestID $request
     * @return RedirectResponse
     */
    public function deleteSingleMail(RequestID $request)
    {
        if (Note::deleteSingleNotification($request->id, 'web'))
            return redirect()->route('user.latest.mailbox')->with('success', 'Mail deleted successfully.');
        return redirect()->back()->with('error', 'Failed to delete notification.');
    }

    /**
     * fetch all notifications
     * @return Factory|View
     */
    public function allMailBox()
    {
        return view('user.mailbox.allMail', [
            'allMails' => Note::allNotifications('web'),
        ]);
    }

    /**
     * delete all mails
     * @return RedirectResponse
     */
    public function deleteAllMails()
    {
        if (Note::deleteAllNotifications('web'))
            return redirect()->route('user.latest.mailbox')->with('success', 'Notification(s) deleted successfully.');
        return redirect()->route('user.latest.mailbox')->with('error', 'Failed to delete notification(s).');
    }

    /**
     * generate report
     * @return Application|Factory|View
     */
    public function generateReportPage()
    {
        return view('user.reports.generate');
    }

    /**
     * generate report
     * @param ReportRequest $request
     * @return mixed
     */
    public function generateReport(ReportRequest $request)
    {
        if ($request->type === 'item') {
            return Excel::download(new ItemReport(
                $request->from_date,
                $request->to_date
            ), 'items.xlsx');
        } elseif ($request->type === 'sale') {
            return Excel::download(new SaleReport(
                $request->from_date,
                $request->to_date
            ), 'sales.xlsx');
        } else {
            return Excel::download(new SupplierReport(
                $request->from_date,
                $request->to_date
            ), 'suppliers.xlsx');
        }
    }


    /**
     * logout user
     * @return Factory|RedirectResponse|View
     */
    public function logout()
    {
        auth()->logout();
        session()->flush();
        return redirect()->route('login');
    }
}
