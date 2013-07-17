<script src="/js/hc/highcharts.js" type="text/javascript"></script>
    <script src="/js/hc/highcharts-more.js" type="text/javascript"></script>
<script>
    
    function init() {
        setInterval(function(){
        <?php
        foreach ($pools as $pool => $host) {
            echo "$('#request_$pool').load('/report/updategraphpool/$pool').fadeIn('slow');";
            echo "$('#load_$pool').load('/report/infopool/$pool/load').fadeIn('slow');";
            echo "$('#status_$pool').load('/report/infopool/$pool/http_status').fadeIn('slow');";
        }
        ?>
        }, 5000);
        $('#graph-total-request').load('/report/graphpool').fadeIn("slow");

    }
    </script>
<script>$(document).ready(init);</script> 

<div class="main">

    <div class="container">
<div class="row">
       <div class="span12">
      		
      		<div class="widget stacked">
                    
                                <div class="widget-header">
					<i class="icon-star"></i>
					<h3>Plataform Status</h3>
				</div> <!-- /widget-header -->
                                
                                <div class="widget-content">                                       
                                    
                                    <section id="tables">
                                            <table class="table table-bordered table-striped table-highlight">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Request</th>
                                                        <th>Load</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        foreach ($pools as $pool => $host) {
                                                            echo "<tr>";
                                                            echo "  <td><a href='/pool/status/$pool' target='_blank'>$pool</a></td>";
                                                            echo "  <td><div align='center' id='request_$pool'><img height='42' width='42' src='/img/loading_100x100.gif'></div></td>";
                                                            echo "  <td><div align='center' id='load_$pool'><img height='42' width='42' src='/img/loading_100x100.gif'></div></td>";
                                                            echo "  <td><div align='center' id='status_$pool'><img height='42' width='42' src='/img/loading_100x100.gif'></div></td>";
                                                            echo "</tr>";
                                                        }
                                                    ?>                                                 
                                                </tbody>
                                            </table>
                                        </section>        
                                </div>
										
			</div> <!-- /widget -->	
			
      		
	    </div> <!-- /span6 -->
            

      	
      </div> <!-- /row -->
      
      
      <div class="row">
       <div class="span12">
      		
      		<div class="widget stacked">
                    
                                <div class="widget-header">
					<i class="icon-star"></i>
					<h3>Request</h3>
				</div> <!-- /widget-header -->
                                
                                <div id="graph-total-request" class="widget-content"></div>
										
			</div> <!-- /widget -->	
			
      		
	    </div> <!-- /span6 -->
            

      	
      </div> <!-- /row -->


    </div> <!-- /container -->
    
</div> <!-- /main -->
