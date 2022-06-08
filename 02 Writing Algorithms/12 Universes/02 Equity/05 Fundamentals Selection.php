<style>
.work-in-progress {
    width: 100%;
    border: 1px solid #f5ae29;
    border-radius: 5px;
    padding: 15px;
    color: #f5ae29;
}
.tip {
    width: 100%;
    border: 1px solid #f5ae29;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
    margin-top: 20px;
}
.tip i {
    color: #f5ae29;
}
.tip-title { 
 font-weight: bold;
color: #f5ae29;
margin-left: 5px;
margin-right: 5px;
}
.tip p { display: inline; }
table th i {
    color: #f5ae29;
}
th.summary {
   font-family: "Courier New"; 
   font-weight: normal;
}
.table.qc-table tbody tr td {
   text-align: left;
}
.implementation {
    font-family: "Courier New";
}
</style>

<p>A fundamental universe lets you select stocks based on corporate fundamental data. This data is powered by <a href="/datasets/morning-star-us-fundamentals">Morningstar®</a> and includes approximately <?php include(DOCS_RESOURCES."/kpis/fundamental-universe-size.php");?> tickers with 900 properties each. Due to the sheer volume of information, fundamental selection is performed on the output of another universe filter. Think of this process as a 2-stage filter. An initial filter function selects a set of stocks and then a fine fundamental filter function selects a subset of those stocks.</p>


<figure>
<img src="https://cdn.quantconnect.com/docs/i/filters.png" class="img-responsive">
<figcaption>QuantConnect Coarse and Fine Universe Selection</figcaption>
</figure>

<p>To add a fundamental universe, in the <code>Initialize</code> method, pass two filter functions to the <code>AddUniverse</code> method. The first filter function can be a <a href='/docs/v2/writing-algorithms/universes/equity#02-Coarse-Universe-Selection'>coarse universe filter</a>, <a href='/docs/v2/writing-algorithms/universes/equity#03-Dollar-Volume-Selection'>dollar volume filter</a>, or an <a href='/docs/v2/writing-algorithms/universes/equity#04-ETF-Constituents-Selection'>ETF constituents filter</a>. The second filter function receives a list of <code>FineFundamental</code> objects and must return a list of <code>Symbol</code> objects. The list of <code>FineFundamental</code> objects contains a subset of the <code>Symbol</code> objects the first filter function returns. The <code>Symbol</code> objects you return from the second function are the constituents of the fundamental universe and LEAN automatically creates subscriptions for them. Don't call <code>AddEquity</code> in the filter function.</p>

<div class="tip">
  <i class="fa fa-lightbulb-o"></i><span class="tip-title">Tip:</span>
  <p>Only <?php include(DOCS_RESOURCES."/kpis/fundamental-universe-size.php");?> assets have fundamental data. If your first filter function receives <code>CoarseFundamental</code> data, you should only select assets that have a true value for their <code>HasFundamentalData</code> property.</p>
</div>

<div class="section-example-container">
<pre class="csharp">
public class MyUniverseAlgorithm : QCAlgorithm {
    public override void Initialize() 
    {
        AddUniverse(MyCoarseFilterFunction, MyFineFundamentalFilterFunction);
    }
    // filter based on CoarseFundamental
    IEnumerable&lt;Symbol&gt; MyCoarseFilterFunction(IEnumerable&lt;CoarseFundamental&gt; coarse) 
    {
         // In addition to further coarse universe selection, ensure the security has fundamental data
         return return (from c in coarse
                        where c.HasFundamentalData
                        select c.Symbol);
    }
    // filter based on FineFundamental
    public IEnumerable&lt;Symbol&gt; FineSelectionFunction(IEnumerable&lt;FineFundamental&gt; fine)
    {
        // Return a list of Symbols
    }
}
</pre>
<pre class="python">
class MyUniverseAlgorithm(QCAlgorithm):
     def Initialize(self):
         self.AddUniverse(self.MyCoarseFilterFunction, self.MyFineFundamentalFunction)

    def MyCoarseFilterFunction(self, coarse):
         # In addition to further coarse universe selection, ensure the security has fundamental data
         return [c.Symbol for c in coarse if c.HasFundamentalData]

    def MyFineFundamentalFunction(self, fine):
         # Return a list of Symbols
</pre>
</div>

<p><code>FineFundamental</code> objects have the following attributes:</p>
<div data-tree='QuantConnect.Data.Fundamental.FineFundamental'></div>



<h4>Example 1: From the top 50 stocks with the highest volume, take 10 with lowest PE-ratio.</h4>
<p>
The simplest example of accessing the fundamental object would be harnessing the iconic PE ratio for a stock. This is a ratio of the price it commands to the earnings of a stock. The lower the PE ratio for a stock, the more affordable it appears.
</p>

<div class="section-example-container">
	<pre class="csharp">// Take the top 50 by dollar volume using coarse
// Then the top 10 by PERatio using fine
AddUniverse(
    coarse =&gt; {
        return (from c in coarse
            where c.Price &gt; 10 &amp;&amp; c.HasFundamentalData
            orderby c.DollarVolume descending
            select c.Symbol).Take(50);
    },
    fine =&gt; {
        return (from f in fine
            orderby f.ValuationRatios.PERatio ascending
            select f.Symbol).Take(10);
    });
</pre>
	<pre class="python"># In Initialize:
self.AddUniverse(self.CoarseSelectionFunction, self.FineSelectionFunction)

def CoarseSelectionFunction(self, coarse):
    sortedByDollarVolume = sorted(coarse, key=lambda x: x.DollarVolume, reverse=True)
    filtered = [ x.Symbol for x in sortedByDollarVolume if x.HasFundamentalData ]
    return filtered[:50]

def FineSelectionFunction(self, fine):
    sortedByPeRatio = sorted(fine, key=lambda x: x.ValuationRatios.PERatio, reverse=False)
    return [ x.Symbol for x in sortedByPeRatio[:10] ]
</pre>
</div>
<p>
There are 900 properties you can use to perform your own filtering. We recommend you review the <a href="https://www.quantconnect.com/data#fundamentals/usa/morningstar">data library</a> page dedicated to this data to fully understand each property.
</p>

<h4>Example 2: The "QC-500", 500 companies which are liquid, profitable and more than 1B volume.
<p>
Due to licensing restrictions, QuantConnect does not have the iconic S&amp;P500 index list, however, we have reconstructed a homemade version which is a 90% replication which we call the QC-500. The QC-500 is too large to paste into this documentation, but we have open sourced the implementation for educational purposes. For more information, see the 
<span class="python"><a href="https://github.com/QuantConnect/Lean/blob/master/Algorithm.Python/ConstituentsQC500GeneratorAlgorithm.py" target="_BLANK">QC500 example algorithm</a></span>
<span class="csharp"><a href="https://github.com/QuantConnect/Lean/blob/master/Algorithm.CSharp/ConstituentsQC500GeneratorAlgorithm.cs" target="_BLANK">QC500 example algorithm</a></span>.
</p>

<h4>Asset Categories</h4>
<p>In addition to valuation ratios, the <a href="https://www.quantconnect.com/datasets/morning-star-us-fundamentals">US Fundamental Data from Morningstar</a> has many other data point attributes, including over 200 different categorization fields for each US stock. These are grouped into sectors, industry groups and industries.</p>

<p>Sectors are large super categories of data. They are accessed with the <code>MorningstarSectorCode</code> property. The following snippet demonstrates the process of screening for stocks in the technology sector:</p>
<div class="section-example-container">
<pre class="python">tech = [x for x in fine if x.AssetClassification.MorningstarSectorCode == MorningstarSectorCode.Technology]
</pre>
</div>

<p>Industry groups are clusters of related industries that tie together. They are accessed with the <code>MorningstarIndustryGroupCode</code> property. The following snippet demonstrates the process of screening for stocks in the agriculture industry group:</p>
<div class="section-example-container">
<pre class="python">ag = [x for x in fine if x.AssetClassification.MorningstarIndustryGroupCode == MorningstarIndustryGroupCode.Agriculture]
</pre>
</div>

<p>Industries are the finest level of classification available. They are the individual industries according to the Morningstar classification system. They are accessed with the <code>MorningstarIndustryCode</code>. The following snippet demonstrates the process of screening for stocks in the coal industry:</p>
<div class="section-example-container">
<pre class="python">coal = [x for x in fine if x.AssetClassification.MorningstarIndustryCode == MorningstarSectorCode.Coal]
</pre>
</div>


<h4>Practical Limitations</h4>
<p>
	Like coarse universes, fine universes allow you to select an unlimited universe of symbols to analyze. Each asset added consumes approximately 5MB of RAM, so you may quickly run out of memory if your universe filter selects many symbols. If you backtest your algorithms in the Algorithm Lab, familiarize yourself with the RAM capacity of your <a href='/docs/v2/our-platform/organizations/resources#02-Backtesting-Nodes'>backtesting</a> and <a href='/docs/v2/our-platform/organizations/resources#04-Live-Trading-Nodes'>live trading nodes</a>. You can help keep your algorithm fast and efficient by only subscribing to the assets you need.
</p>
