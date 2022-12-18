<p>We model the Coinbase API by supporting several order types, supporting order properties, and not supporting order updates. When you deploy live algorithms, you can <a href='/docs/v2/our-platform/live-trading/algorithm-control#03-Place-Manual-Trades'>place manual orders</a> through the IDE.</p>

<h4>Order Types</h4>

<p>The following table describes the available order types for each asset class that Coinbase supports:</p>

<table class="qc-table table" id='order-types-table'>
   <thead>
      <tr>
        <th style='width: 50%'>Order Type</th>
        <th>Crypto</th>
      </tr>
   </thead>
   <tbody>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/market-orders'>MarketOrder</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/limit-orders'>LimitOrder</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-market-orders'>StopMarketOrder</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"><br>Supported after 2019-03-23 in backtests. For reference, see the <a rel="nofollow" target="_blank" href="https://blog.coinbase.com/coinbase-pro-market-structure-update-fbd9d49f43d7">Coinbase Market Structure Update</a> on the Coinbase website.</td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-limit-orders'>StopLimitOrder</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
   </tbody>
</table>
<style>
#order-types-table td:not(:first-child), 
#order-types-table th:not(:first-child) {
    text-align: center;
}
</style>


<p>Coinbase supports the following order types:</p>

<div class="section-example-container">
    <pre class="csharp">MarketOrder(_symbol, quantity);
LimitOrder(_symbol, quantity, limitPrice);
StopMarketOrder(_symbol, quantity, stopPrice);
StopLimitOrder(_symbol, quantity, stopPrice, limitPrice);</pre>
    <pre class="python">self.MarketOrder(self.symbol, quantity)
self.LimitOrder(self.symbol, quantity, limit_price)
self.StopMarketOrder(self.symbol, quantity, stop_price)
self.StopLimitOrder(self.symbol, quantity, stop_price, limit_price)</pre>
</div>

<h4>Order Properties</h4>
<p>We model custom order properties from the Coinbase API. The following table describes the members of the <code>GDAXOrderProperties</code> object that you can set to customize order execution:</p>

<table class="table qc-table">
    <thead>
        <tr>
            <th style="width: 25%">Property</th>
            <th style="width: 75%">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>TimeInForce</code></td>
            <td>A <code>TimeInForce</code> instruction to apply to the order. The <code>GoodTilCanceled</code> <code>TimeInForce</code> is supported.</td>
        </tr>
        <tr>
            <td><code>PostOnly</code></td>
            <td>A flag that signals the order must only add liquidity to the order book and not take liquidity from the order book. If part of the order results in taking liquidity rather than providing liquidity, the order is rejected without any part of it being filled.</td>
        </tr>
    </tbody>
</table>


<div class="section-example-container">
    <pre class="csharp">public override void Initialize()
{
    // Set the default order properties
    DefaultOrderProperties = new GDAXOrderProperties
    {
        TimeInForce = TimeInForce.GoodTilCanceled,
        PostOnly = false
    };
}

public override void OnData(Slice slice)
{
    // Use default order order properties
    LimitOrder(_symbol, quantity, limitPrice);
    
    // Override the default order properties
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new GDAXOrderProperties
               { 
                   TimeInForce = TimeInForce.GoodTilCanceled,
                   PostOnly = true
               });
}</pre>
    <pre class="python">def Initialize(self) -&gt; None:
    # Set the default order properties
    self.DefaultOrderProperties = GDAXOrderProperties()
    self.DefaultOrderProperties.TimeInForce = TimeInForce.GoodTilCanceled
    self.DefaultOrderProperties.PostOnly = False

def OnData(self, slice: Slice) -&gt; None:
    # Use default order order properties
    self.LimitOrder(self.symbol, quantity, limit_price)
    
    # Override the default order properties
    order_properties = GDAXOrderProperties()
    order_properties.TimeInForce = TimeInForce.GoodTilCanceled
    order_properties.PostOnly = True
    self.LimitOrder(self.symbol, quantity, limit_price, orderProperties=order_properties)</pre>
</div>

<h4>Updates</h4>
<p>We model the Coinbase API by not supporting order updates, but you can cancel an existing order and then create a new order with the desired arguments.</p>

<div class="section-example-container">
    <pre class="csharp">var ticket = LimitOrder(_symbol, quantity, limitPrice);
ticket.Cancel();
ticket = LimitOrder(_symbol, newQuantity, newLimitPrice);</pre>
    <pre class="python">ticket = self.LimitOrder(self.symbol, quantity, limit_price)
ticket.Cancel()
ticket = self.LimitOrder(self.symbol, new_quantity, new_limit_price)</pre>
</div>