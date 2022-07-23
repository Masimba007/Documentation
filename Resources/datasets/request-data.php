<?php

$getRequestDataText = function($isWritingAlgorithms)
{
    echo "<p>The simplest form of history request is for a known set of <code>Symbol</code> objects. ";
    if ($isWritingAlgorithms)
    {
        echo "This is common for fixed universes of securities or when you need to prepare new securities added to your algorithm. ";
    }
    echo "History requests return slightly different data depending on the overload you call. The data that returns is in ascending order from oldest to newest. ";
    if ($isWritingAlgorithms)
    {
        echo "This order is necessary to use the data to warm up indicators."; 
    }
    echo "</p>
    
    <h4>Single Symbol History Requests</h4>
    
    ";
}





<p>To request history for a single asset, pass the asset <code>Symbol</code> to the <code>History</code> method. The return type of the method call depends on the history request <code class="python">[Type]</code><code class="csharp">&lt;Type&gt;</code>. The following table describes the return type of each request <code class="python">[Type]</code><code class="csharp">&lt;Type&gt;</code>:</p>

<table class="qc-table table">
    <thead>
        <tr>
            <th>Request Type</th>
            <th>Return Data Type</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>No argument</td>
	    <td><code class="python">DataFrame</code><code class="csharp">List&lt;TradeBar&gt;</code></td>
        </tr>
        <tr>
	    <td><code>TradeBar</code></td>
	    <td><code class="python">List[TradeBars]</code><code class="csharp">List&lt;TradeBar&gt;</code></td>
        </tr>
        <tr>
	    <td><code>QuoteBar</code></td>
	    <td><code class="python">List[QuoteBars]</code><code class="csharp">List&lt;QuoteBar&gt;</code></td>
        </tr>
        <tr>
	    <td><code>Tick</code></td>
	    <td><code class="python">List[Ticks]</code><code class="csharp">List&lt;Tick&gt;</code></td>
        </tr>
    </tbody>
</table>


<p class="python">Each row of the DataFrame represents the prices at a point in time. Each column of the DataFrame is a property of that price data (for example, open, high, low, and close).</p>

<div class="section-example-container">
<pre class="python"><b># EXAMPLE 1: Requesting By Bar Count: 5 bars at the security resolution:</b>
btc_symbol = self.AddCrypto("BTCUSD", Resolution.Minute).Symbol
trade_bars = self.History[TradeBar](btc_symbol, 5)
quote_bars = self.History[QuoteBar](btc_symbol, 5)
df = self.History(btc_symbol, 5)
<img class="img-responsive img-thumbnail " src="https://cdn.quantconnect.com/i/tu/history-request-single-symbol-1.png">
</pre>
<pre class="csharp"><b>// EXAMPLE 1: Requesting By Bar Count: 5 bars at the security resolution:</b>
var btcSymbol = AddCrypto("BTCUSD", Resolution.Minute).Symbol;
var tradeBars = History&lt;TradeBar&gt;(btcSymbol, 5);
var quoteBars = History&lt;QuoteBar&gt;(btcSymbol, 5);
var tradeBars2 = History(btcSymbol, 5);</pre>

	
<pre class="python"><b># EXAMPLE 2: Requesting By Bar Count: 5 bars with a specific resolution:</b>
trade_bars = self.History[TradeBar](btc_symbol, 5, Resolution.Daily)
quote_bars = self.History[QuoteBar](btc_symbol, 5, Resolution.Minute)
df = self.History(btc_symbol, 5, Resolution.Minute)
<img class="img-responsive img-thumbnail " src="https://cdn.quantconnect.com/i/tu/history-request-single-symbol-1.png">
</pre>
<pre class="csharp"><b>// EXAMPLE 2: Requesting By Bar Count: 5 bars with a specific resolution:</b>
var tradeBars = History&lt;TradeBar&gt;(btcSymbol, 5, Resolution.Daily);
var quoteBars = History&lt;QuoteBar&gt;(btcSymbol, 5, Resolution.Minute);
var tradeBars2 = History(btcSymbol, 5, Resolution.Minute);</pre>


<pre class="python"><b># EXAMPLE 3: Requesting By Period: 3 days of data at the security resolution:</b> 
eth_symbol = self.AddCrypto("ETHUSD", Resolution.Tick).Symbol
ticks = self.History[Tick](eth_symbol, timedelta(days=3))

trade_bars = self.History[TradeBar](btc_symbol, timedelta(days=3)) 
quote_bars = self.History[QuoteBar](btc_symbol, timedelta(days=3))
df = self.History(btc_symbol, timedelta(days=3)) 
<img class="img-responsive img-thumbnail " src="https://cdn.quantconnect.com/i/tu/history-request-single-symbol-2.png"></pre>
<pre class="csharp"><b>// EXAMPLE 3: Requesting By Period: 3 days of data at the security resolution:</b>
var ethSymbol = AddCrypto("ETHUSD", Resolution.Tick).Symbol;
var ticks = History&lt;Tick&gt;(ethSymbol, TimeSpan.FromDays(3));

var tradeBars = History&lt;TradeBar&gt;(btcSymbol, TimeSpan.FromDays(3));
var quoteBars = History&lt;QuoteBar&gt;(btcSymbol, TimeSpan.FromDays(3));
var tradeBars2 = History(btcSymbol, TimeSpan.FromDays(3));</pre>
	
	
	
<pre class="python"><b># EXAMPLE 4: Requesting By Period: 3 days of data with a specific resolution:</b> 
trade_bars = self.History[TradeBar](btc_symbol, timedelta(days=3), Resolution.Daily) 
quote_bars = self.History[QuoteBar](btc_symbol, timedelta(days=3), Resolution.Minute)
ticks = self.History[Tick](eth_symbol, timedelta(days=3), Resolution.Tick)
df = self.History(btc_symbol, timedelta(days=3), Resolution.Hour) 
<img class="img-thumbnail img-responsive" src="https://cdn.quantconnect.com/i/tu/history-request-single-symbol-3.png">
# Important Note: Period history requests are relative to "now" algorithm time.</pre>


<pre class="csharp"><b>// EXAMPLE 4: Requesting By Period: 3 days of data with a specific resolution:</b>
var tradeBars = History&lt;TradeBar&gt;(btcSymbol, TimeSpan.FromDays(3), Resolution.Daily);
var quoteBars = History&lt;QuoteBar&gt;(btcSymbol, TimeSpan.FromDays(3), Resolution.Minute);
var ticks = History&lt;Tick&gt;(ethSymbol, TimeSpan.FromDays(3), Resolution.Tick);
var tradeBars2 = History(btcSymbol, TimeSpan.FromDays(3), Resolution.Minute);</pre>
</div>

<h4>Multiple Symbol History Requests</h4>
<p>
To request history for multiple symbols at a time, pass an array of Symbol objects to the same API methods shown in the preceding section. The return type of the method call depends on the history request <code class="python">[Type]</code><code class="csharp">&lt;Type&gt;</code>. The following table describes the return type of each request <code class="python">[Type]</code><code class="csharp">&lt;Type&gt;</code>:</p>

<table class="qc-table table">
    <thead>
        <tr>
            <th>Request Type</th>
            <th>Return Data Type</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>No argument</td>
	    <td><code class="python">DataFrame</code><code class="csharp">List&lt;Slice&gt;</code></td>
        </tr>
        <tr>
	    <td><code>TradeBar</code></td>
	    <td><code class="python">List[TradeBars]</code><code class="csharp">List&lt;TradeBars&gt;</code></td>
        </tr>
        <tr>
	    <td><code>QuoteBar</code></td>
	    <td><code class="python">List[QuoteBars]</code><code class="csharp">List&lt;QuoteBars&gt;</code></td>
        </tr>
        <tr>
	    <td><code>Tick</code></td>
	    <td><code class="python">List[Ticks]</code><code class="csharp">List&lt;Ticks&gt;</code></td>
        </tr>
    </tbody>
</table>


<p class="csharp">The <code>Slice</code> return type provides a container that supports all data types. For example, a history request for Forex <code>QuoteBars</code> and Equity <code>TradeBars</code> has the Forex data under <code>slices.QuoteBars</code> and the Equity data under <code>slices.Bars</code>.</p>

<div class="section-example-container">
<pre class="python"><b># EXAMPLE 5: Requesting By Bar Count for Multiple Symbols: 2 bars at the security resolution:</b>
ibm = self.AddEquity("IBM", Resolution.Minute).Symbol
aapl = self.AddEquity("AAPL", Resolution.Minute).Symbol
trade_bars_list = self.History[TradeBar]([ibm, aapl], 2)
quote_bars_list = self.History[QuoteBar]([ibm, aapl], 2)
df = self.History([ibm, aapl], 2)
<img class="img-responsive img-thumbnail " src="https://cdn.quantconnect.com/i/tu/history-request-single-symbol-4.png">
</pre>

<pre class="csharp"><b>// EXAMPLE 5: Requesting By Bar Count for Multiple Symbols: 2 bars at the security resolution:</b>
var ibm = AddEquity("IBM", Resolution.Minute).Symbol;
var aapl = AddEquity("AAPL", Resolution.Minute).Symbol;
var tradeBarsList = History&lt;TradeBar&gt;(new[] { ibm, aapl }, 2);
var quoteBarsList = History&lt;QuoteBar&gt;(new[] { ibm, aapl }, 2);
</pre>
	
<pre class="python"><b># EXAMPLE 6: Requesting By Bar Count for Multiple Symbols: 5 bars with a specific resolution:</b>
trade_bars_list = self.History[TradeBar]([ibm, aapl], 5, Resolution.Daily)
quote_bars_list = self.History[QuoteBar]([ibm, aapl], 5, Resolution.Minute)
df = self.History([ibm, aapl], 5, Resolution.Daily)
<img class="img-responsive img-thumbnail " src="https://cdn.quantconnect.com/i/tu/history-request-single-symbol-5.png">
</pre>

<pre class="csharp"><b>// EXAMPLE 6: Requesting By Bar Count for Multiple Symbols: 5 bars with a specific resolution:</b>
var tradeBarsList = History&lt;TradeBar&gt;(new[] { ibm, aapl }, 5, Resolution.Minute);
var quoteBarsList = History&lt;QuoteBar&gt;(new[] { ibm, aapl }, 5, Resolution.Minute);
</pre>
	
	
<pre class="python"><b># EXAMPLE 7: Requesting By Period: 3 days of data at the security resolution:</b> 
ticks = self.History[Tick]([eth_symbol], timedelta(days=3))

trade_bars = self.History[TradeBar]([btc_symbol], timedelta(days=3)) 
quote_bars = self.History[QuoteBar]([btc_symbol], timedelta(days=3))
df = self.History([btc_symbol], timedelta(days=3)) 
<img class="img-responsive img-thumbnail " src="https://cdn.quantconnect.com/i/tu/history-request-single-symbol-6.png"></pre>
<pre class="csharp"><b>// EXAMPLE 7: Requesting By Period: 3 days of data at the security resolution:</b>
var ticks = History&lt;Tick&gt;(new[] {ethSymbol}, TimeSpan.FromDays(3));

var tradeBars = History&lt;TradeBar&gt;(new[] {btcSymbol}, TimeSpan.FromDays(3));
var quoteBars = History&lt;QuoteBar&gt;(new[] {btcSymbol}, TimeSpan.FromDays(3));
var tradeBars2 = History(new[] {btcSymbol}, TimeSpan.FromDays(3));</pre>	

</div>

<h4>All Symbol History Requests</h4>
<p>You can request history for all active securities in your universe. The parameters are very similar to other history method calls, but the return type is an array of <a href="/docs/v2/writing-algorithms/key-concepts/time-modeling/timeslices">Slice</a> objects. The <code>Slice</code> object holds all of the results in a sorted enumerable collection that you can iterate over with a loop.</p>

<div class="section-example-container">
<pre class="python"><b># EXAMPLE 1: Requesting 5 bars for all securities at their respective resolution:</b>

# Setting up the universe
self.AddEquity("IBM", Resolution.Daily)
self.AddEquity("AAPL", Resolution.Daily)

# Request history data and enumerate results
slices = self.History(5)
for s in slices:
    self.Log(str(s.Time) + " AAPL:" + str(s.Bars["AAPL"].Close) + " IBM:" + str(s.Bars["IBM"].Close))
<img class="img-responsive img-thumbnail " src="https://cdn.quantconnect.com/i/tu/history-request-single-symbol-7.png">
</pre>

<pre class="csharp"><b>// EXAMPLE 1: Requesting 5 bars for all securities at their respective resolution:</b>

// Set up the universe
AddEquity("IBM", Resolution.Daily);
AddEquity("AAPL", Resolution.Daily);

// Request history data and enumerate results:
var slices = History(5);
foreach (var s in slices) {
    Debug($"{s.Time} AAPL: {s.Bars["AAPL"].Close} IBM: {s.Bars["IBM"].Close}");
}
<img class="img-responsive img-thumbnail " src="https://cdn.quantconnect.com/i/tu/history-request-single-symbol-9.png">
</pre>
</div>

<div class="section-example-container">  
<pre class="python"><b># EXAMPLE 2: Requesting 5 minutes for all securities:</b>

slices = self.History(timedelta(minutes=5), Resolution.Minute)
for s in slices:
    self.Log(str(s.Time) + " AAPL:" + str(s.Bars["AAPL"].Close) + " IBM:" + str(s.Bars["IBM"].Close))
<img class="img-responsive img-thumbnail " src="https://cdn.quantconnect.com/i/tu/history-request-single-symbol-8.png">
# timedelta history requests are relative to "now" in Algorithm Time. If you request this data at 16:05, it returns an empty array because the market is closed.</pre>

    
<pre class="csharp"><b>// EXAMPLE 2: Requesting 24 hours of hourly data for all securities:</b>

var slices = History(TimeSpan.FromHours(24), Resolution.Hour);
foreach (var s in slices) {
     Debug($"{s.Time} AAPL: {s.Bars["AAPL"].Close} IBM: {s.Bars["IBM"].Close}");
}
<img class="img-responsive img-thumbnail" src="https://cdn.quantconnect.com/i/tu/history-request-single-symbol-10.png">
// TimeSpan history requests are relative to "now" in Algorithm Time.</pre>

</div>

<h4>Assumed Default Values</h4>
<p>The following table describes the assumptions of the History API:</p>
<table class="table qc-table">
    <thead>
        <tr>
            <th>Argument</th>
            <th>Assumption</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Resolution</td>
            <td>LEAN guesses the resolution you request by looking at the securities you already have in your algorithm. If you have a security subscription in your algorithm with a matching <code>Symbol</code>, the history request uses the same resolution as the subscription. If you don't have a security subscription in your algorithm with a matching <code>Symbol</code>, <code>Resolution.Minute</code> is the default.</td>
        </tr>
        <tr class="csharp">
            <td>Bar type</td>
            <td>If you don't specify a type for the history request, <code>TradeBar</code> is the default. If the asset you request data for doesn't have <code>TradeBar</code> data, specify the <code>QuoteBar</code> type to receive history.</td>
        </tr>
    </tbody>
</table>

<h4>Additional Options</h4>
<p>If you call the <code>History</code> method with a list of <code>Symbol</code> objects, a start date, an end date, and a resolution, then you can pass the following additional arguments:</p>

<table class="qc-table table">
    <thead>
        <tr>
            <th>Argument</th>
            <th>Data Type</th>
            <th>Description</th>
            <th>Default Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>fillForward</code></td>
	        <td><code class="csharp">bool?</code><code class="python">bool/NoneType</code></td>
            <td>True to <a href="/docs/v2/writing-algorithms/securities/subscriptions#05-Fill-Forward">fill forward</a> missing data. Otherwise, false.</td>
            <td><code class="csharp">null</code><code class="python">None</code></td>
        </tr>
        <tr>
            <td><code>extendedMarket</code></td>
	        <td><code class="csharp">bool?</code><code class="python">bool/NoneType</code></td>
            <td>True to include extended market hours data. Otherwise, false.</td>
            <td><code class="csharp">null</code><code class="python">None</code></td>
        </tr>
        <tr>
            <td><code>dataMappingMode</code></td>
	        <td><code class="csharp">DataMappingMode?</code><code class="python">DataMappingMode/NoneType</code></td>
            <td>The <a href="/docs/v2/writing-algorithms/universes/futures#12-Continous-Contracts">contract mapping mode</a> to use for the security history request.</td>
            <td><code class="csharp">null</code><code class="python">None</code></td>
        </tr>
        <tr>
            <td><code>dataNormalizationMode</code></td>
            <td><code class="csharp">DataNormalizationMode?</code><code class="python">DataNormalizationMode/NoneType</code></td>
            <td>The price scaling mode to use for <a href="/docs/v2/writing-algorithms/securities/asset-classes/us-equity/requesting-data#09-Data-Normalization">US Equities</a> or <a href="/docs/v2/writing-algorithms/universes/futures#12-Continous-Contracts">continuous Futures contracts</a>. If you don't provide a value, it uses the data normalization mode of the security subscription.</td>
            <td><code class="csharp">null</code><code class="python">None</code></td>
        </tr>
        <tr>
            <td><code>contractDepthOffset</code></td>
            <td><code class="csharp">int?</code><code class="python">int/NoneType</code></td>
            <td>The desired offset from the current front month for <a href="/docs/v2/writing-algorithms/universes/futures#12-Continous-Contracts">continuous Futures contracts</a>.</td>
            <td><code class="csharp">null</code><code class="python">None</code></td>
        </tr>
    </tbody>
</table>


<div class="section-example-container">
    <pre class="python">self.future = self.AddFuture(Futures.Currencies.BTC)
history = self.History(
    tickers=[self.future.Symbol], 
    start=self.Time - timedelta(days=15), 
    end=self.Time, 
    resolution=Resolution.Minute, 
    fillForward=False, 
    extendedMarket=False, 
    dataMappingMode=DataMappingMode.OpenInterest, 
    dataNormalizationMode=DataNormalizationMode.Raw, 
    contractDepthOffset=0)</pre>
    <pre class="csharp">var future = AddFuture(Futures.Currencies.BTC);
var history = History(
    symbols: new[] {future.Symbol}, 
    start: Time - TimeSpan.FromDays(15),
    end: Time,
    resolution: Resolution.Minute,
    fillForward: false,
    extendedMarket: false,
    dataMappingMode: DataMappingMode.OpenInterest,
    dataNormalizationMode: DataNormalizationMode.Raw,
    contractDepthOffset: 0);</pre>
</div>
  
?>
