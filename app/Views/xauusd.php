<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <title>Gold sport</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="shortcut icon" type="image/png" href="../favicon.ico"> -->
        <link rel="shortcut icon" type="image/png" href="<?=base_url();?>gold.ico">

        <!-- Bootstrap 5 -->
        <link href="<?=base_url();?>asset/bootstrap.min.css" rel="stylesheet">
        <script src="<?=base_url();?>asset/jquery.slim.min.js"></script>
        <script src="<?=base_url();?>asset/popper.min.js"></script>
        <script src="<?=base_url();?>asset/bootstrap.bundle.min.js"></script>

        <!-- CSS ICONS -->
        <!-- <link href="<?=base_url();?>asset/bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">
        <link href="<?=base_url();?>asset/fontawesome4/css/font-awesome.min.css" rel="stylesheet"> -->

        <!-- JQuery -->
        <script src="<?=base_url();?>asset/jquery-3.7.1.min.js"></script>
        
        <!-- Sweetalert2 -->
        <!-- <script src="<?=base_url();?>asset/sweetalert2/sweetalert2.all.min.js"></script>
        <link href="<?=base_url();?>asset/sweetalert2/sweetalert2.min.css" rel="stylesheet"> -->

        <!-- my custom css -->
        <!-- <link rel="stylesheet" href="<?=base_url();?>css/style.css"> -->

        
        <!-- <script src="https://www.bullionvault.com/chart/bullionvaultchart.js"></script> -->
        <script src="<?=base_url();?>asset/bullionvaultchart.js"></script>

        <!-- cookieconsent -->
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.1.0/dist/cookieconsent.css"> -->
    </head>
<body>
    <style>
        .d-chartbg {
            background-color: #343330;
            min-height: 100vh;
        }
        
        #chartContainer {
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);

            min-height: 500px;
            width: 100%; 
            max-width: 900px;
        }
    </style>


    <div class="row">
        <div class="col-12 bg-dark">
            <div class="text-center p-2 mt-5">
                <h2 class="text-light">XAUUSD</h2>
            </div>

            
            <div class="d-chartbg mt-3 pt-4">
                <div id="chartContainer"></div>
            </div>
        </div>
    </div>

    <script>
        // Chart configuration options
        var options = {
        bullion: 'gold',              // 'gold', 'silver', 'platinum', 'palladium'
        currency: 'USD',              // 'USD', 'GBP', 'EUR', 'JPY', 'AUD', 'CAD', 'CHF'
        timeframe: '1h',              // '10m','1h','6h','1d','1w','1m','1q','1y','5y','20y'
        chartType: 'line',            // 'line' or 'hlc' (high-low-close)
        
        miniChartMode: false,         // true = tiny version (no controls)
        displayLatestPriceLine: true, // show current price line + timestamp
        containerDefinedSize: true,   // respect our div's size

        // UI controls (set false to hide)
        switchBullion: true,
        switchCurrency: true,
        switchTimeframe: true,
        switchChartType: true,
        exportButton: true,

        // Optional: referral tracking (replace with your BullionVault username if affiliate)
        // referrerID: 'YOURUSERNAME'
        };

        // Create the chart
        var chartBV = new BullionVaultChart(options, 'chartContainer');
        
        function getPrice() {
            // var valueline = $(".highcharts-plot-line-label").text();
            var valueline = [];
            $('.highcharts-plot-line-label').each(function(index){
                // ดึงข้อความของแต่ละ element
                var text = $(this).text();

                // แสดงผลหรือเก็บไว้ใน array
                // console.log("Element " + index + ": " + text);
                valueline[index] = text;
            });

            // console.log("<< valueline >>");
            // console.log(valueline[0]);
            // console.log(valueline[1]);

            const now = new Date();
        
            // Time with leading zeros
            let h = String(now.getHours()).padStart(2, '0');
            let m = String(now.getMinutes()).padStart(2, '0');
            let s = String(now.getSeconds()).padStart(2, '0');
            
            // Optional: Show current date below
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            var dateTime = now.toLocaleDateString('th-TH', dateOptions); 

            var payload = {
                datetime: new Date().toISOString(),
                thdate: dateTime,
                price: valueline[1],
                des: valueline[0]
            };

            console.log("[Obj payload]");
            console.log(payload);

            $.ajax({
                url: 'https://script.google.com/macros/s/AKfycbz__Eq2Z14gX-R8hQ7x6IsQ89zQYgcU3yZa-7CIrym5yq_m7t8FRVlFtSiig0fbjgHF/exec',
                method: 'POST',
                contentType: 'text/plain; charset=utf-8',   // ← key change
                // or even simpler: 'application/x-www-form-urlencoded'
                data: JSON.stringify(payload),                 // still JSON string, just different mime
                processData: false,
                success: function(res) {
                    console.log("Received:", res);
                },
                error: function(xhr, textStatus, error) {
                    console.error(textStatus, error, xhr.status, xhr.responseText);
                }
            });

            // $.ajax({
            //     url: 'https://script.google.com/macros/s/AKfycbydlB9Rt57BSv5w3PxvZlFuNt9oO4haPd7C6kHuIDTyTI1WXwOMy3AbaYbPWjxWvznN/exec',
            //     method: 'POST',
            //     contentType: 'application/json',
            //     processData: false,                // ← very important with JSON
            //     data: JSON.stringify(payload),
            //     dataType: 'json',                  // let jQuery try to parse response as JSON
            //     timeout: 15000,                    // 15 seconds – adjust according to your GAS logic
            //     success: function(response, textStatus, jqXHR) {
            //         console.log('Success!', response);
            //         // Most common GAS responses:
            //         // { "result": "success", "message": "...", "data": {...} }
            //         // or just plain string "ok" / "error: something"
                    
            //         if (response?.result === 'success') {
            //             alert('Data saved!');
            //         } else {
            //             console.warn('GAS returned non-success result:', response);
            //         }
            //     },
            //     error: function(jqXHR, textStatus, errorThrown) {
            //         console.error('AJAX failed:', textStatus, errorThrown);
            //         console.log('Status code:', jqXHR.status);
            //         console.log('Response:', jqXHR.responseText);
                    
            //         let msg = 'Cannot connect to server';
            //         if (jqXHR.status === 0) {
            //             msg = 'CORS / network error or script not deployed as web app';
            //         } else if (jqXHR.status === 403 || jqXHR.status === 401) {
            //             msg = 'Script permission issue (check "Execute as" & "Who has access")';
            //         } else if (textStatus === 'timeout') {
            //             msg = 'Request timed out – Google Apps Script is slow today';
            //         }
                    
            //         alert(msg);
            //     }
            // });
            
            // $.ajax({
            //     url: "https://script.google.com/macros/s/AKfycbydlB9Rt57BSv5w3PxvZlFuNt9oO4haPd7C6kHuIDTyTI1WXwOMy3AbaYbPWjxWvznN/exec", // ใส่ URL /exec ตรงนี้
            //     type: "POST",
            //     contentType: "application/json",
            //     data: JSON.stringify(data),
            //     success: function(response) {
            //         console.log(response);
            //     },
            //     error: function(err) {
            //         console.log("Error: " + JSON.stringify(err));
            //     }
            // });
        }

        $(document).ready(function(){
            // getPrice(); // first load
            setInterval(getPrice, 60000);

            setTimeout(function() {
                console.log("getData Chart [1]");
                getPrice();
            }, 2000);

        });
    </script>
</body>
</html>