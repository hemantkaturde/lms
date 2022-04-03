         
           
            <footer class="page-footer">
                <div class="font-13">2018 © <b>AdminCAST</b> - All rights reserved.</div>
                <a class="px-4" href="http://themeforest.net/item/adminca-responsive-bootstrap-4-3-angular-4-admin-dashboard-template/20912589" target="_blank">BUY PREMIUM</a>
                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
            </footer>
        </div>
    </div>
  
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <!-- <script src="<?php echo base_url(); ?>assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script> -->
    <!-- <script src="<?php echo base_url(); ?>assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script> -->
    <!-- <script src="<?php echo base_url(); ?>assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script> -->
    <!-- <script src="<?php echo base_url(); ?>assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script> -->
    <!-- CORE SCRIPTS-->
    <!-- <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="<?php echo base_url(); ?>assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script>
   <script src="<?php echo base_url(); ?>assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
   
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/jquery-validation/dist/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom/common.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom/master.js" type="text/javascript"></script>
   <script type="text/javascript">
        $(function() {
            $('#example-table').DataTable({
                pageLength: 10,
                //"ajax": './assets/demo/data/table_data.json',
                /*"columns": [
                    { "data": "name" },
                    { "data": "office" },
                    { "data": "extn" },
                    { "data": "start_date" },
                    { "data": "salary" }
                ]*/
            });
        })
    </script>
</body>
</html>