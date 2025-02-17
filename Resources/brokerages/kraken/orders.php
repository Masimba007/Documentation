
<h4>Order Types</h4>
<p>The following table describes the available order types for each asset class that <?= $cloudPlatform ? "our Kraken integration" : "the <code>KrakenBrokerageModel</code>" ?> supports:</p>

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
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/limit-if-touched-orders'>LimitIfTouchedOrder</a></td>
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

<h4>Order Properties</h4>
<p><?= $writingAlgorithms ? "The <code>KrakenBrokerageModel</code> supports custom order properties." : "We model custom order properties from the Kraken API." ?> The following table describes the members of the <code>KrakenOrderProperties</code> object that you can set to customize order execution:</p>

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
            <td>A <a href='/docs/v2/writing-algorithms/trading-and-orders/order-properties#03-Time-In-Force'>TimeInForce</a> instruction to apply to the order. The following instructions are supported:
                <ul>
                    <li><code>Day</code></li>
                    <li><code>GoodTilCanceled</code></li>
                    <li><code>GoodTilDate</code></li>
                </ul>
            </td>
        </tr>
        <tr>
            <td><code>PostOnly</code></td>
            <td>A flag to signal that the order must only add liquidity to the order book and not take liquidity from the order book. If part of the order results in taking liquidity rather than providing liquidity, the order is rejected without any part of it being filled.</td>
        </tr>
        <tr>
            <td><code>FeeInBase</code></td>
            <td>A flag to signal that the order fees should be paid in the base currency, which is the default behavior when selling. This flag must be the opposite of the <code>FeeInQuote</code> flag.</td>
        </tr>
        <tr>
            <td><code>FeeInQuote</code></td>
            <td>A flag to signal that the order fees should be paid in the quote currency, which is the default behavior when buying. This flag must be the opposite of the <code>FeeInBase</code> flag.</td>
        </tr>
        <tr>
            <td><code>NoMarketPriceProtection</code></td>
            <td>A flag to signal that no <a rel="nofollow" target="_blank" href="https://support.kraken.com/hc/en-us/articles/201648183-Market-Price-Protection">Market Price Protection</a> should be used.</td>
        </tr>
        <tr>
            <td><code>ConditionalOrder</code></td>
            <td>An <code>Order</code> that's submitted when the primary order is executed. The <code>ConditionalOrder</code> quantity must match the primary order quantity and the <code>ConditionalOrder</code> direction must be the opposite of the primary order direction. This order property is only available for live algorithms.</td>
        </tr>
    </tbody>
</table>

<?php if ($writingAlgorithms) { ?>
<div class="section-example-container">
    <pre class="csharp">public override void Initialize()
{
    // Set the default order properties
    DefaultOrderProperties = new KrakenOrderProperties
    {
        TimeInForce = TimeInForce.GoodTilCanceled,
        PostOnly = false,
        FeeInBase = true,
        FeeInQuote = false,
        NoMarketPriceProtection = true
    };
}

public override void OnData(Slice slice)
{
    // Use default order order properties
    LimitOrder(_symbol, quantity, limitPrice);
    
    // Override the default order properties
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new KrakenOrderProperties
               { 
                   TimeInForce = TimeInForce.Day,
                   PostOnly = true,
                   FeeInBase = false,
                   FeeInQuote = true,
                   NoMarketPriceProtection = true
               });
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new KrakenOrderProperties
               { 
                   TimeInForce = TimeInForce.GoodTilDate(new DateTime(year, month, day)),
                   PostOnly = false,
                   FeeInBase = true,
                   FeeInQuote = false,
                   NoMarketPriceProtection = false,
                   ConditionalOrder = StopLimitOrder(_symbol, -quantity, stopLimitPrice, stopPrice)
               });
}</pre>
    <pre class="python">def Initialize(self) -&gt; None:
    # Set the default order properties
    self.DefaultOrderProperties = KrakenOrderProperties()
    self.DefaultOrderProperties.TimeInForce = TimeInForce.GoodTilCanceled
    self.DefaultOrderProperties.PostOnly = False
    self.DefaultOrderProperties.FeeInBase = True
    self.DefaultOrderProperties.FeeInQuote = False
    self.DefaultOrderProperties.NoMarketPriceProtection = True

def OnData(self, slice: Slice) -&gt; None:
    # Use default order order properties
    self.LimitOrder(self.symbol, quantity, limit_price)
    
    # Override the default order properties
    order_properties = KrakenOrderProperties()
    order_properties.TimeInForce = TimeInForce.Day
    order_properties.PostOnly = True
    order_properties.FeeInBase = False
    order_properties.FeeInQuote = True
    order_properties.NoMarketPriceProtection = True
    self.LimitOrder(self.symbol, quantity, limit_price, orderProperties=order_properties)

    order_properties.TimeInForce = TimeInForce.GoodTilDate(datetime(year, month, day))
    order_properties.PostOnly = False
    order_properties.FeeInBase = True
    order_properties.FeeInQuote = False
    order_properties.NoMarketPriceProtection = False
    order_properties.ConditionalOrder = StopLimitOrder(self.symbol, -quantity, stop_limit_price, stop_price)
    self.LimitOrder(self.symbol, quantity, limit_price, orderProperties=order_properties)</pre>
</div>
<?php } ?>

<h4>Updates</h4>
<p><?= $writingAlgorithms ? "The <code>KrakenBrokerageModel</code> doesn't support order updates" : "We model the Kraken API by not supporting order updates" ?>, but you can cancel an existing order and then create a new order with the desired arguments. For more information about this workaround, see the <a href='/docs/v2/writing-algorithms/trading-and-orders/order-management/order-tickets#workaround-for-brokerages-that-dont-support-updates'>Workaround for Brokerages That Don’t Support Updates</a>.</p>

