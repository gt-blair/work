<?php include "../../includes/facilities/FacilitiesController.php";
$facilities = new Facility();
?>
<?php $facilitiesList = $facilities->viewAllFacilities(); ?>

<?php session_start(); ?>
<?php $facilitiesList = $facilities->getSingleFacility($_GET['id']);
$row = $facilitiesList->fetch(PDO::FETCH_ASSOC); ?>

<?php
include "../../includes/Session.php";
$session = new Session();
$session->checkSession();
include "../../includes/solutionsheader.php";
?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js" integrity="sha512-UXumZrZNiOwnTcZSHLOfcTs0aos2MzBWHXOHOuB0J/R44QB0dwY5JgfbvljXcklVf65Gc4El6RjZ+lnwd2az2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/2.0.1/chartjs-plugin-zoom.min.js" integrity="sha512-wUYbRPLV5zs6IqvWd88HIqZU/b8TBx+I8LEioQ/UC0t5EMCLApqhIAnUg7EsAzdbhhdgW07TqYDdH3QEXRcPOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    

    
    
        
    
    <div>
    <div style='float:right; width:25%; height:100vh; display: flex; justify-content:space-between; flex-direction:column; '>
    <input style=' margin-right: 1.5; margin-top:10px' class="btn btn-sm btn-default" onclick="home()" value="home">
    <h5 id='facilityName' style=' margin-top:7px;'><a style='font-size:25px' href="https://www.agakhanhospitals.org/en/aga-khan-hospital-kisumu" target='_blank'><center><u>@<?= $row['facility_type'] ?></u></center></a></h5>
    <div style='display: flex; justify-content:space-between; flex-direction:column; height:93%'>
    <div style='padding-left:5%;width:98%; height: 50%; '>
    <canvas style='width:100%'id='myDonut'></canvas>
    <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.812402082001!2d34.75394427426699!3d-0.09868659990033862!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182aa48dc6bf50b5%3A0x3e784950b1b9121c!2sAga%20Khan%20Hospital!5e0!3m2!1sen!2ske!4v1692205526689!5m2!1sen!2ske" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>-->
    </div>
    <div style='width:100%; height: 40%; display: flex; justify-content:space-between; flex-direction:column;'>
    <div style='padding-right: 1.5%;padding-left: 1.5%;'>
        <p style='margin-bottom: 0px;'><strong>Choose Day:</strong></p>
        <input class="form-input form-control form-group" onchange='filterHour(this)' type="date" value='2021-09-22' id='hourFilter'>
    </div>
    <div style='padding-right: 1.5%;padding-left: 1.5%;'>
        <p style='margin-bottom: 0px'><strong>Choose Month:</strong></p>
        <input class="form-input form-control form-group" value='2021-09' onchange='filterMonth(this)' type="month" id="monthFilter">
    </div>
    <div style='padding-right: 1.5%;padding-left: 1.5%;'>
        <p style='margin-bottom: 0px'><strong>Choose Start Period:</strong></p>
        <input class="form-input form-control form-group" value='2021-09-22' onchange='filterDay()' type="date" id="startDayFilter" required>
        <p style='margin-bottom: 0px'><strong>Choose End Period:</strong></p>
        <input class="form-input form-control form-group" value='2022-02-26' onchange='filterDay()' type="date" id="endDayFilter" required>
    </div>
    </div>
    <input style='float: right; margin-right: 1.5%; margin-top:0px' class="btn btn-sm btn-default" onclick="toMap()" value="view on map">
    <!--<input style='float: right; margin-right: 10px; margin-top:0px' class="btn btn-sm btn-default" onclick="home()" value="home">-->
    </div>
    </div>
    <div class='container' style=' width: 75%; float:left; '>
    <div style='display: flex; justify-content:space-between; flex-direction:row; width:100%; height: 5vh; padding: 5px;'>
    
    <div style='  margin-top:5px'><h4 ></h4></div>
    <h2 id='facilityName' style=' font-size:40px; color:blue'><u><?= $row['name'] ?></u></h2>
    <div style='  margin-top:5px'><h4 ></h4></div>
    
    <!--<div style='float: right; margin-right: 10px; margin-top:5px'><a href="">Home</a></div>-->
  </div>
    <div id="chartContainer" style="height: 65vh; margin-bottom: 50px; margin-top: 30px; padding: 10px; ">
    <canvas style='border-radius:12.5px; box-shadow: 2px 2px 10px; width:100%'id='myCHART'></canvas>
    </div>
<div style='display: flex; justify-content:space-between; flex-direction:row; '>
<div  style='box-shadow: 2px 2px 10px; display: flex; justify-content:space-between; flex-direction:column; width:250px; height:150px;background:linear-gradient( #00FFFF, #7fffd4); border-radius:25px; margin-top:auto; margin-bottom:auto; height:100%'>
    <h4 style='color:black; font-size:25px; text-align:center; margin-top:auto; margin-bottom:auto' id='from'></h4>
</div>
<div style='display: flex; justify-content:space-between; flex-direction:row; '>
    <div  style= 'box-shadow: 2px 2px 10px;text-overflow:ellipsis; overflow:hidden; padding-left:auto; padding-right:auto; background:linear-gradient(#00FFFF,blue); border-radius:50%; height:200px; width:200px; padding-top:75px; text-align:justify; text-justify:inter-word'>
            
            <h4 style='color:yellow; font-size:25px; text-align:center'id='kwh'>Litres</h4>
            
    </div>
    <div style='box-shadow: 2px 2px 10px; margin-left:2%;margin-right:2%; background:linear-gradient(#00FFFF,blue); margin-top:auto; margin-bottom:auto; padding-left:auto; padding-right:auto; text-align:center;  border-radius:50%; height:100px; width:100px; padding-top:25px; padding-bottom:25px; text-align:justify; text-justify:inter-word'>
            
            <h4 style='color:white; font-size:20px; text-align:center'id='tarrif'>Taffif</h4>
            
    </div>
    <div style='box-shadow: 2px 2px 10px; text-overflow:ellipsis; overflow:hidden; padding-left:auto; padding-right:auto; background:linear-gradient(#00FFFF,blue); border-radius:50%; height:200px; width:200px; padding-top: 75px; text-align:justify; text-justify:inter-word'>
            
            <h4 style='color:yellow; font-size:25px; text-align:center' id='cost'>COST</h4>
            
    </div>

</div>
<div style='box-shadow: 2px 2px 10px; display: flex; justify-content:space-between; flex-direction:column; width:250px; height:150px;background:linear-gradient( #00FFFF, #7fffd4); border-radius:25px; margin-top:auto; margin-bottom:auto; height:100%'>
    <h4 style='color:black; font-size:25px; text-align:center;margin-top:auto; margin-bottom:auto;'  id='to'></h4>
</div>
</div>
    
    </div>
    
    
    </div>
    
    
</div>
<!--<div style='float:right; margin-top: 60px; padding-right: 100px; padding-top:100px;'>
    <p>Aga Khan Facility</p>
    <a href="">View Location</a>

</div>-->
</div>
<!--<script>
        
    async function fetchData(){
        const url = 'Data/<?= $row['name'] ?>.json';
        const response = await fetch(url);
        const datapoints = await response.json();
        //console.log(datapoints);
        return datapoints;
     }

     //console.log(fetchData());

    

     fetchData().then(datapoints => {
        console.log(datapoints);
        let time = [];
        let units = [];
        let unitsMath = [];

        for (let i=0; i< datapoints.length; i++){
            time.push(datapoints[i].time);
            units.push(datapoints[i].units);
            unitsMath.push(datapoints[i].units);
        }
        console.log(datapoints.length);
        console.log(time.length);
        console.log(units.length);
        console.log(unitsMath.length);


        let overallUnit = 0;
        for (let i=0; i < unitsMath.length; i++){
            let entryUnit = unitsMath[i];
            overallUnit = overallUnit + entryUnit;
        }

        let overallCost = overallUnit * unitCost;

        kwhTag.innerHTML = `<strong>${overallUnit.toFixed(4)} Litres</strong> <br> `;
        costTag.innerHTML = `<strong>Ksh.${overallCost.toFixed(2)}</strong> <br> `;
        fromTag.innerHTML = `<h5><strong>From:</strong> ${time[0]}</h5>`;
        toTag.innerHTML = `<h5><strong>To:</strong> ${time[time.length-1]}</h5>`;

        console.log(overallUnit);


        let ctx = document.getElementById('myCHART');
        let donutx = document.getElementById('myDonut');

        const data = {
            labels: time,
            datasets:[{
                label: 'Consumption in Litres',
                data: units,
                backgroundColor: '#00FFFF',
                borderColor: '#00FFFF',
            }]
        };

        const data2 = {
            labels: [
                'Usage Comparison',
            ],
            datasets: [{
                label: 'Litres',
                data: [overallUnit],
                backgroundColor: [
                '#00ffff',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
                ],
                hoverOffset: 6
            }]
            };

        const config = {
        type: 'line',
        data,
        options:{
            scales: {
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Litres'
                    }
                },
                x : {
                    min: '2021-10-22 00:00:00',
                    max: '2022-02-26 11:00:00',
                    type: 'time',
                    time: {
                        unit: 'month'
                    },
                    title: {
                        display: true,
                        text: 'Time'
                    }
                }
            },
                plugins: {
                zoom: {
                    pan:{
                        enabled: true,
                        mode: 'x'
                        
                        },

                    zoom: {
                        wheel: {
                            enabled: true
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'x'
                    }
                }
            }
        }
    };

    const config2 = {
        type: 'doughnut',
        data: data2,
        };


        const myCHART = new Chart(ctx, config);
        const myDonutx = new Chart(donutx, config2);
        //myCHART.destroy()
     })

     async function toMap(){
        
        window.open('<?= $row['coordinates'] ?>' , "_blank");
     }

     async function home() {
        //let datapoints = await fetchData();
        //console.log(datapoints);
        //event.stopPropagation();
        history.back();
    };

    async function filterMonth(date){
        let datapoints = await fetchData();
        let dates2 = [];
        let units2 = [];
        let unitMath = [];

        for (let i=0; i<datapoints.length; i++){
            dates2.push(datapoints[i].time);
            units2.push(datapoints[i].units);
            unitMath.push(datapoints[i].units);
        }

        console.log(dates2);
        console.log(units2);

        let ctx = document.getElementById('myCHART');


        const year = date.value.substring(0,4);
        const month = date.value.substring(5,7);
        console.log(`MONTTTTTTTTTTTTHHHHHHH ${month}`)
        const lastDay = (y,m) => {
            return new Date(y, m, 0).getDate();
        }
        const startDate = `${date.value}-01`;
        const endDate = `${date.value}-${lastDay(year,month)}`;

        const indexStartMonthDate =  dates2.indexOf(`${startDate} 00:00:00`);
        console.log(indexStartMonthDate);
        const indexEndMonthDate = dates2.indexOf(`${endDate} 00:00:00`);
        

        const data = {
            labels: dates2,
            datasets:[{
                label: 'Consumption in Litres',
                data: units2,
                backgroundColor: '#00FFFF',
                borderColor: '#00FFFF',
            }]
        };

        const config = {
        type: 'line',
        data,
        options:{
            scales: {
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Units'
                    }
                },
                x : {
                    min: startDate,
                    max: endDate,
                    type: 'time',
                    time: {
                        unit: 'day'
                    },
                    title: {
                        display: true,
                        text: 'Time'
                    }
                }
            },
                plugins: {
                zoom: {
                    pan:{
                        enabled: true,
                        mode: 'x'
                        
                        },

                    zoom: {
                        wheel: {
                            enabled: true
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'x'
                    }
                }
            }
        }
    };

        let chartStatus = Chart.getChart("myCHART");
        console.log(chartStatus)

        if (chartStatus != undefined) {
            chartStatus.destroy();
        }

        const myCHART = new Chart(ctx, config);

        console.log(date.value);

        var previousMonth = 0;
        var nextMonth = 0;

        if( month == '05' || month == '10'){
            previousMonth = 30;
            nextMonth = 30;
        } else if(month== '02' || month== '04' ||month== '06'||month== '09'||month== '11') {
            previousMonth = 31;
            nextMonth = 31;
        } else if(month== '01') {
            previousMonth = 31;
            nextMonth = 28;
        } else if(month== '03') {
            previousMonth = 28;
            nextMonth = 31;
        } else if(month== '07') {
            previousMonth = 30;
            nextMonth = 31;
        } else if(month== '08') {
            previousMonth = 31;
            nextMonth = 30;
        } else if(month== '12') {
            previousMonth = 30;
            nextMonth = 31;
        } 

        

        //lastDay(year, month);


        console.log(indexEndMonthDate);

        var unitMonthSum = 0;
        var unitPrevSum = 0;
        var unitNextSum = 0;

        



        for (let i=indexStartMonthDate; i < indexEndMonthDate + 1; i ++){
            let unitMonthValue = unitMath[i];
            console.log(unitMonthValue);
            unitMonthSum = unitMonthSum + unitMonthValue;
            //console.log(unitMonthSum.toFixed(4));
        }

        for (let i=indexStartMonthDate-24*previousMonth ; i < indexStartMonthDate -24; i ++){
            let unitMonthValue = unitMath[i];
            console.log(unitMonthValue);
            unitPrevSum = unitPrevSum + unitMonthValue;
            //console.log(unitMonthSum.toFixed(4));
        } 

        for (let i=indexEndMonthDate + 24; i < indexEndMonthDate + 24 * nextMonth ; i ++){
            let unitMonthValue = unitMath[i];
            //console.log(unitMonthValue);
            unitNextSum = unitNextSum + unitMonthValue;
            //console.log(unitMonthSum.toFixed(4));
        }


        

        var totalMonthCost = unitMonthSum * unitCost;



        let donutx = document.getElementById('myDonut');

        const data2 = {
            labels: [
                'Current Month',
                'Previous Month',
                'Next Month'
            ],
            datasets: [{
                label: 'Litres',
                data: [unitMonthSum, unitPrevSum, unitNextSum],
                backgroundColor: [
                '#00ffff',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
                ],
                hoverOffset: 6
            }]
            };

            const config2 = {
            type: 'doughnut',
            data: data2,
            };

        let chartStatus2 = Chart.getChart("myDonut");
        console.log(chartStatus2)

        if (chartStatus2 != undefined) {
            chartStatus2.destroy();
        }

        const myDonutx = new Chart(donutx, config2);


































        //kWhTag.innerHTML = '<strong>kWh</strong> <br> wassgood';
        kwhTag.innerHTML = `<strong>${unitMonthSum.toFixed(4)} Litres</strong> <br> `;
        costTag.innerHTML = `<strong>Ksh.${totalMonthCost.toFixed(2)}</strong> <br> `;
        fromTag.innerHTML = `<h5><strong>From:</strong> ${`${startDate} 00:00:00`}</h5>`;
        toTag.innerHTML = `<h5><strong>To:</strong> ${`${endDate} 00:00:00`}</h5>`;


        //myCHART.config.options.scales.x.time.unit = 'day';
        //myCHART.config.options.scales.x.min = startDate;
        //myCHART.config.options.scales.x.max = endDate;
        //myCHART.update();

       // const myCHART = new Chart(ctx, config);


    }


    async function filterDay(){
        let datapoints = await fetchData();
        let dates2 = [];
        let units2 = [];
        let unitMath = [];
        //console.log(dates2.length);
        //console.log(units2.length);

        for (let i=0; i<datapoints.length; i++){
            dates2.push(datapoints[i].time);
            units2.push(datapoints[i].units);
            unitMath.push(datapoints[i].units);
        }

        console.log(dates2);
        console.log(units2);

        let ctx = document.getElementById('myCHART');

        const startDate = document.getElementById('startDayFilter');
        const endDate = document.getElementById(
            'endDayFilter'
        );
        console.log(`${startDate.value} 00:00:00`);

        const indexStartDate = dates2.indexOf(`${startDate.value} 00:00:00`);
        const indexEndDate = dates2.indexOf(`${endDate.value} 00:00:00`);


        const data = {
            labels: dates2,
            datasets:[{
                label: 'Consumption in Litres',
                data: units2,
                backgroundColor: '#00FFFF',
                borderColor: '#00FFFF',
            }]
        };

        const config = {
        type: 'line',
        data,
        options:{
            scales: {
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Litres'
                    }
                },
                x : {
                    min: `${startDate.value} 00:00:00`,
                    max: `${endDate.value} 00:00:00`,
                    type: 'time',
                    time: {
                        unit: 'day'
                    },
                    title: {
                        display: true,
                        text: 'Time'
                    }
                }
            },
                plugins: {
                zoom: {
                    pan:{
                        enabled: true,
                        mode: 'x'
                        
                        },

                    zoom: {
                        wheel: {
                            enabled: true
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'x'
                    }
                }
            }
        }
    };

        let chartStatus = Chart.getChart("myCHART");
        console.log(chartStatus)

        if (chartStatus != undefined) {
            chartStatus.destroy();
        }

        const myCHART = new Chart(ctx, config);


        
        console.log(indexStartDate, indexEndDate);

        const filterDate = dates2.slice(indexStartDate, indexEndDate + 1);

        
        var unitDaySum = 0;
        var unitMathSum = 0;



        for (let i=indexStartDate; i < indexEndDate + 1; i ++){
            let unitDayValue = unitMath[i];
            //console.log(unitMonthValue);
            unitDaySum = unitDaySum + unitDayValue;
            console.log(unitDaySum.toFixed(4));
        }


        for (let i=0; i < unitMath.length; i ++){
            let unitDayValue = unitMath[i];
            //console.log(unitMonthValue);
            unitMathSum = unitMathSum + unitDayValue;
            //console.log(unitDaySum.toFixed(4));
        }

        var restMonthSum = unitMathSum - unitDaySum


        var totalDayCost = unitDaySum * unitCost;






















        let donutx = document.getElementById('myDonut');

        const data2 = {
            labels: [
                'Current Period',
                'Rest of Period',
                
            ],
            datasets: [{
                label: 'Litres',
                data: [unitDaySum, restMonthSum],
                backgroundColor: [
                '#00ffff',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
                ],
                hoverOffset: 6
            }]
            };

            const config2 = {
            type: 'doughnut',
            data: data2,
            };

        let chartStatus2 = Chart.getChart("myDonut");
        console.log(chartStatus2)

        if (chartStatus2 != undefined) {
            chartStatus2.destroy();
        }

        const myDonutx = new Chart(donutx, config2);       















        //kwhTag.innerHTML = '<strong>KWH</strong> <br> wassgood';
        kwhTag.innerHTML = `<strong>${unitDaySum.toFixed(4)} Litres</strong> <br> `;
        costTag.innerHTML = `<strong>Ksh.${totalDayCost.toFixed(2)}</strong> <br> `;
        fromTag.innerHTML = `<h5><strong>From:</strong> ${dates2[indexStartDate]}</h5>`;
        toTag.innerHTML = `<h5><strong>To:</strong> ${dates2[indexEndDate]}</h5>`;

        //myCHART.config.options.scales.x.min = `${startDate.value} 00:00:00`,
        //myCHART.config.options.scales.x.max = `${endDate.value} 00:00:00`,
        //myCHART.config.data.labels = filterDate;
        //myCHART.config.options.scales.x.time.unit = 'day';
        //myCHART.update();
    }
    

    async function filterHour(day){
        let datapoints = await fetchData();
        let dates2 = [];
        let units2 = [];
        let unitMath = [];

        for (let i=0; i<datapoints.length; i++){
            dates2.push(datapoints[i].time);
            units2.push(datapoints[i].units);
            unitMath.push(datapoints[i].units);
        }

        console.log(dates2);
        console.log(units2);

        let ctx = document.getElementById('myCHART');

        const startHour = `${day.value} 00:00:00`;
        console.log(day.value);

        const indexStartHour = dates2.indexOf(startHour);

        console.log(indexStartHour);
        
        const indexEndHour = indexStartHour + 24;

        const endHour = dates2[indexEndHour];

        
        const data = {
            labels: dates2,
            datasets:[{
                label: 'Consumption in Litres',
                data: units2,
                backgroundColor: '#00FFFF',
                borderColor: '#00FFFF',
            }]
        };

        const config = {
        type: 'line',
        data,
        options:{
            scales: {
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Litres'
                    }
                },
                x : {
                    min: startHour,
                    max: endHour,
                    type: 'time',
                    time: {
                        unit: 'hour'
                    },
                    title: {
                        display: true,
                        text: 'Time'
                    }
                }
            },
                plugins: {
                zoom: {
                    pan:{
                        enabled: true,
                        mode: 'x'
                        
                        },

                    zoom: {
                        wheel: {
                            enabled: true
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'x'
                    }
                }
            }
        }
    };

        let chartStatus = Chart.getChart("myCHART");
        console.log(chartStatus)

        if (chartStatus != undefined) {
            chartStatus.destroy();
        }

        const myCHART = new Chart(ctx, config);

        
        console.log(startHour, endHour);


        var unitHourSum = 0;
        var prev24Sum = 0;
        var next24Sum = 0;

        var prev24hr = indexStartHour - 24;
        var next24hr = indexEndHour + 24;

        for (let i=indexStartHour; i < indexEndHour + 1; i ++){
            let unitHourValue = unitMath[i];
            //console.log(unitMonthValue);
            unitHourSum = unitHourSum + unitHourValue;
            //console.log(unitHourSum.toFixed(4));
        }

        for (let i=prev24hr; i < indexStartHour; i ++){
            let unitHourValue = unitMath[i];
            //console.log(unitMonthValue);
            prev24Sum = prev24Sum + unitHourValue;
            //console.log(unitHourSum.toFixed(4));
        }

        for (let i=indexEndHour + 1; i < next24hr + 1; i ++){
            let unitHourValue = unitMath[i];
            //console.log(unitMonthValue);
            next24Sum = next24Sum + unitHourValue;
            //console.log(unitHourSum.toFixed(4));
        }




        let donutx = document.getElementById('myDonut');

        const data2 = {
            labels: [
                'Current Day',
                'Previous Day',
                'Next Day'
            ],
            datasets: [{
                label: 'Litres',
                data: [unitHourSum, prev24Sum, next24Sum],
                backgroundColor: [
                '#00ffff',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
                ],
                hoverOffset: 6
            }]
            };

            const config2 = {
            type: 'doughnut',
            data: data2,
            };

        let chartStatus2 = Chart.getChart("myDonut");
        console.log(chartStatus2)

        if (chartStatus2 != undefined) {
            chartStatus2.destroy();
        }

        const myDonutx = new Chart(donutx, config2);       



























        var totalHourCost = unitHourSum * unitCost;

        //kwhTag.innerHTML = '<strong>KWH</strong> <br> wassgood';
        kwhTag.innerHTML = `<strong>${unitHourSum.toFixed(4)} Litres</strong> <br> `;
        costTag.innerHTML = `<strong>Ksh.${totalHourCost.toFixed(2)}</strong> <br> `;
        fromTag.innerHTML = `<h5><strong>From:</strong>${startHour}</h5>`;
        toTag.innerHTML = `<h5><strong>To:</strong> ${endHour}</h5>`;






        //myCHART.config.options.scales.x.time.unit = 'hour';
        //myCHART.config.options.scales.x.min = startHour;
        //myCHART.config.options.scales.x.max = endHour;
        //myCHART.update();


    }



    </script>

    <script>
        let kwhTag = document.getElementById('kwh');
        let costTag = document.getElementById('cost');
        let unitCost = 20;
        let toTag = document.getElementById('to');
        let fromTag = document.getElementById('from');
        let tarrif = document.getElementById('tarrif');
        tarrif.innerHTML = `<strong>Tarrif</strong> <br> ${unitCost}`;

        console.log(toTag);
        console.log(fromTag);

        //console.log(kwhTag);
        //console.log(costTag);
        //console.log(unitCost);
        
    </script>

-->


<script>
    var data = {
        labels: [15],
        datasets: [
            {
                label: 'Dataset 1',
                data: [15],
                lineTension: 0.5
            }
        ]
    };

    var config = {
        type: 'line',
        data: data,
        options:{
            scales: {
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Units'
                    }
                },
                x : {
                    title: {
                        display: true,
                        text: 'Time'
                    }
                }
            },
                plugins: {
                zoom: {
                    pan:{
                        enabled: true,
                        mode: 'x'
                        
                        },

                    zoom: {
                        wheel: {
                            enabled: true
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'x'
                    }
                }
            }
        }
    };


    const myChart = new Chart(
      document.getElementById('myCHART'),
      config
    );

    window.setInterval(mycallback,5000);

    function mycallback() {
        var now = new Date();
        now = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
        var value = Math.floor(Math.random() * 1000);
        data.labels.push(now);
        data.datasets[0].data.push(value);
        
        if (data.labels.length > 20){
          data.labels = []
          data.datasets[0].data = []
        }

        myChart.update();

        console.log(data.labels)
        console.log(data.datasets[0].data)

        
    }




    console.log("Hello World")


</script>