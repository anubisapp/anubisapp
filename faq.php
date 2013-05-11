<?php require("auth.inc.php"); ?>
<?php require('head.inc.php'); ?>

    <div class="container">
        <div class="page-header">
            <div class="row-fluid">
                <div class="left">
                    <h1>FAQ</h1>
                </div>
            </div>
        </div>
        <section id="contents">
        <h4>Whats this?</h4>
        <p>AnubisApp is a web frontend for CGMINER (<a href="https://bitcointalk.org/index.php?topic=28402.0">https://bitcointalk.org/index.php?topic=28402.0</a>) the combined GPU and FPGA bitcoin and litecoin miner for Windows/Linux.<br />
        AnubisApp "watches" your hosts by connecting to the API port of CGMINER.
        </p>

        <h4>How do I enable it?</h4>
        <p>The connection is very simple, just add "--api-listen" (and "--api-network") to the CGMINER command line and CGMINER's API is enabled.
           After installing AnubisApp simply start by <a href="addhost.php">adding some hosts</a>.
        </p>

        <h4>Installation?</h4>
        <p>All you need is a PHP/MySQL enabled host. Usually run by a <a href="http://www.wampserver.com/en/" target="_blank">WAMP</a> or <a href="http://wiki.debian.org/LaMp" target="_blank">LAMP</a> software stack. This host has to be able to reach your miners by network i.e. you should be able to ping your miners from the PHP/MySQL enabled host. Simple copy all the AnubisApp files into a directory of your choice into your webserver root and call it there like: http://my.host.com/anubis i.e.</p>
        <p>Please follow the guidelines in the README for further instructions. If you have any issues during installation then please head on over to our <a href="https://github.com/anubisapp/anubisapp/issues">AnubisApp issues</a> section on Github.</p>

        <h4>Something is wrong/does not work as expected.</h4>
        <p>Since we are in a very early development stage of AnubisApp there will surely be bugs. If you have found a bug or have any suggestions please head on over to our <a href="https://github.com/anubisapp/anubisapp/issues">AnubisApp issues</a> section and submit an issue with a detailed bug report or your suggestion.</p>

        <h4>This is epic! I want to help.</h4>
        <p>Thanks! Well, good news miner - you can contribute in multiple ways. Head over to the <a href="https://github.com/anubisapp/anubisapp/">AnubisApp repository</a> and fork it. Alter the software in any way you think it will do good to the project and submit a pull request. If your work has some added value to the project we will merge it right back into AnubisApp!</p>
        <p>But if your coding skills aren't really kickass you can always help us out by submitting a (small) <a href="contact.php">donation</a> so we can keep this project going. Highly appreciated!</p>
        </section>
    </div>
    <div id="push"></div>
</div>

<?php include("footer.inc.php"); ?>

</body>
</html>
