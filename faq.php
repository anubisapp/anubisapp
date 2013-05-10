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
        <h4>Whats this ?</h4>
        <p>AnubisApp is a web frontend for cgminer (<a href="https://bitcointalk.org/index.php?topic=28402.0">https://bitcointalk.org/index.php?topic=28402.0</a>) a bitcoin miner for windows/linux.
           AnubisApp "watches" your hosts by connecting to the API Port of cgminer.
        </p>
        <h4>How Do I enable it ?</h4>
        <p>The Connection is very simple, just add "--api-listen" (and "--api-network") to the cgminer command line and cgminer's api is enabled.
           After installing AnubisApp simply start by <a href="addhost.php">adding some hosts.</a>
        </p>
        <h4>Something is wrong/does not work as expected.</h4>
        <p>Since we are in a very early development stage of AnubisApp there will surely be bugs. If you have found a bug or have any suggestions or improvements you wish to make yourself please head on over to our GitHub page <a href="https://github.com/anubisapp/anubisapp/issues">here</a>.</p>
        <h4>Installation ?</h4>
        <p>All you need is a php/mysql enabled host. This host has to be able to reach your miners by network i.e. you should be able to ping your miners from the php/mysql enabled host. Simple copy all the AnubisApp files into a directory of your choice into your webserver root and call it there like: http://my.host.com/anubis i.e.</p>
        <p>Please follow the guidelines in the README for further instructions. If you have any issues during installation then please head on over to our issues sections on the <a href="https://github.com/anubisapp/anubisapp/issues">GitHub</a> page for AnubisApp.</p>
        </section>
    </div>
    <div id="push"></div>
</div>

<?php include("footer.inc.php"); ?>

</body>
</html>
