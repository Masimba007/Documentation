<p>Kraken supports cash and margin accounts.</p>

<?php echo file_get_contents(DOCS_RESOURCES."/brokerages/set-brokerage-model/kraken.html"); ?>

<h4>Create an Account</h4>
<p>Follow the <a rel='nofollow' target='_blank' href="https://www.kraken.com/sign-up">account creation wizard</a> on the Kraken website to create a Kraken account.</p>

<p>You will need API credentials to deploy live algorithms with your brokerage account. After you open your account, <a rel="nofollow" target="_blank" href="https://support.kraken.com/hc/en-us/articles/360000919966-How-to-generate-an-API-key-pair-">create API credentials</a> and store them somewhere safe.</p>


<h4>Paper Trading</h4>
<p>The Kraken brokerage doesn't support paper trading, but you can follow these steps to simulate it:</p>

<ol>
    <li>In the <code>Initialize</code> method of your algorithm, add one of the preceding <code>SetBrokerageModel</code> method calls.</li>
    <li><a href="/docs/v2/cloud-platform/live-trading/brokerages/quantconnect-paper-trading#14-Deploy-Live-Algorithms">Deploy your algorithm with the QuantConnect Paper Trading brokerage</a>.</li>
</ol>