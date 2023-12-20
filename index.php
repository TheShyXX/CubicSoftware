<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                margin: 50px;
            }

            #randomNumberDisplay,#dataCollect,#result{
                font-size: 24px;
                margin-bottom: 20px;
            }

            #startCollection {
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
            }
        </style>
        <title>Random Number Collector</title>
    </head>
    <body>
        <div id="randomNumberDisplay"></div>
        <button id="startCollection">Start Data Collection</button>
        <div id="dataCollect"></div>
        <div id="result" style="color: green"></div>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let collectionInterval;
                let displayInterval;
                let collectedDigits = "";
                let randomNumber = generateRandomNumber();

                function generateRandomNumber() {
                    return Math.floor(10000 + Math.random() * 90000);
                }

                function displayRandomNumber() {
                    displayInterval = setInterval(function () {
                        randomNumber = generateRandomNumber();
                        document.getElementById('randomNumberDisplay').textContent = `Random Number: ${randomNumber}`;
                    }, 1000);
                }

                function startDataCollection() {
                    document.getElementById('startCollection').disabled = true;
                    collectedDigits = "";
                    collectionInterval = setInterval(function () {
                        const lastDigit = String(randomNumber).slice(-1);
                        collectedDigits += lastDigit;
                        document.getElementById('dataCollect').textContent = `Collected Number: ${collectedDigits}`;
                    }, 1000);

                    setTimeout(stopDataCollection, 5000);
                }

                function stopDataCollection() {
                    document.getElementById('startCollection').disabled = false;
                    clearInterval(collectionInterval);
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'server_save.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            document.getElementById('result').textContent = `Status: ${xhr.responseText}`;
                            setTimeout(function () {
                                document.getElementById('result').textContent = '';
                            }, 2000);
                        }
                    };
                    xhr.send(`data=${collectedDigits}`);
                }

                document.getElementById('startCollection').addEventListener('click', startDataCollection);

                displayRandomNumber();
            });
        </script>
        <!--   JQUERY VERSION
                    <script>
                    $(document).ready(function () {
                        let collectionInterval;
                        let displayInterval;
                        let collectedDigits = "";
                        let randomNumber = generateRandomNumber();
        
                        function generateRandomNumber() {
                            return Math.floor(10000 + Math.random() * 90000);
                        }
        
                        function displayRandomNumber() {
                            displayInterval = setInterval(function () {
                                randomNumber = generateRandomNumber();
                                $('#randomNumberDisplay').text(`Random Number: ${randomNumber}`);
                            }, 1000);
                        }
        
        
                        function startDataCollection() {
                            $('#startCollection').prop('disabled', true);
                            collectedDigits = "";
                            collectionInterval = setInterval(function () {
                                const lastDigit = String(randomNumber).slice(-1);
                                collectedDigits += lastDigit;
                                $('#dataCollect').text(`Collected Number: ${collectedDigits}`);
                            }, 1000);
        
                            setTimeout(stopDataCollection, 5000);
                        }
        
        
                        function stopDataCollection() {
                            $('#startCollection').prop('disabled', false);
                            clearInterval(collectionInterval);
                            $.ajax({
                                url: "server_save.php",
                                type: "post",
                                data: {data: collectedDigits},
                                success: function (response) {
                                    $('#result').text(`Status: ${response}`);
                                setTimeout(function () {
                                $('#result').text(``);
                                }, 2000);
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                }
                            });
                        }
        
        
                        $('#startCollection').on('click', startDataCollection);
        
        
                        displayRandomNumber();
                    });
                </script>-->
    </body>
</html>
