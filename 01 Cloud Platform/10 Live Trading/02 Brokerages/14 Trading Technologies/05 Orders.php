<p>We model the TT API by supporting several order types, the <code>TimeInForce</code> order property, and order updates. When you deploy live algorithms, you can <a href='/docs/v2/cloud-platform/live-trading/algorithm-control#03-Place-Manual-Trades'>place manual orders</a> through the IDE.</p>

<h4>Order Types</h4>

<p>The following table describes the available order types for each asset class that TT supports:</p>

<table class="qc-table table" id='order-types-table'>
   <thead>
      <tr>
        <th style='width: 50%'>Order Type</th>
        <th>Futures</th>
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
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
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

<p>TT enforces the following order rules:</p>
<ul>
    <li>If you are buying (selling) with a <code>StopMarketOrder</code> or a <code>StopLimitOrder</code>, the stop price of the order must be greater (less) than the current security price.</li>
    <li>If you are buying (selling) with a <code>StopLimitOrder</code>, the limit price of the order must be greater (less) than the stop price.</li>
</ul>

<h4>Time In Force</h4>
<p>We model the <code>TimeInForce</code> order property from the TT API. TT supports the <code>Day</code> and <code>GoodTilCanceled</code> <code>TimeInForce</code> properties.</p>

<div class="section-example-container">
    <pre class="csharp">public override void Initialize()
{
    // Set the default order properties
    DefaultOrderProperties.TimeInForce = TimeInForce.GoodTilCanceled;
}

public override void OnData(Slice slice)
{
    // Use default order order properties
    LimitOrder(_symbol, quantity, limitPrice);
    
    // Override the default order properties
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new OrderProperties
               { 
                   TimeInForce = TimeInForce.Day 
               });
}</pre>
    <pre class="python">def Initialize(self) -&gt; None:
    # Set the default order properties
    self.DefaultOrderProperties.TimeInForce = TimeInForce.GoodTilCanceled

def OnData(self, slice: Slice) -&gt; None:
    # Use default order order properties
    self.LimitOrder(self.symbol, quantity, limit_price)
    
    # Override the default order properties
    order_properties = OrderProperties()
    order_properties.TimeInForce = TimeInForce.Day
    self.LimitOrder(self.symbol, quantity, limit_price, orderProperties=order_properties)</pre>
</div>

<h4>Updates</h4>
<p>We model the TT API by supporting order updates. You can define the following members of <code>UpdateOrderFields</code> object to update active orders:</p>

<ul>
    <li><code>Quantity</code></li>
    <li><code>LimitPrice</code></li>
    <li><code>StopPrice</code><code></code></li><li><code>Tag</code></li>
</ul>

<div class="section-example-container">
    <pre class="csharp">var ticket = StopLimitOrder(symbol, quantity, stopPrice, limitPrice, tag);
var orderFields = new UpdateOrderFields { <br>    Quantity = newQuantity,<br>    LimitPrice = newLimitPrice,<br>    StopPrice = newStopPrice,<br>    Tag = newTag<br>};
ticket.Update(orderFields);</pre>
    <pre class="python">ticket = self.StopLimitOrder(symbol, quantity, stop_price, limit_price, tag)<br>update_fields = UpdateOrderFields()
update_fields.Quantity = new_quantity<br>update_fields.LimitPrice = new_limit_price<br>update_fields.StopPrice = new_stop_price
update_fields.Tag = new_tag
ticket.Update(update_fields)</pre>
</div>

