<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 2.0.0
  </div>
  <strong>Copyright © 2022 <a href="#"> Dinkominfo Kabupaten Banjarnegara</a>.</strong> 
</footer>

</div>

<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?=base_url('adminLTE/plugins/jquery/jquery.min.js')?>"></script>
<!-- jquery-validation -->
<script src="<?=base_url('adminLTE/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
<script src="<?=base_url('adminLTE//plugins/jquery-validation/additional-methods.min.js')?>"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<!-- Select2 -->
<script src="<?=base_url('adminLTE/plugins/select2/js/select2.full.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('adminLTE/dist/js/adminlte.min.js')?>"></script>
<!-- DataTables  & Plugins -->
<script src="<?=base_url('adminLTE/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?=base_url('adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')?>"></script>
<script src="<?=base_url('adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')?>"></script>
<script src="<?=base_url('adminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js')?>"></script>
<script src="<?=base_url('adminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')?>"></script>
<script src="<?=base_url('adminLTE/plugins/jszip/jszip.min.js')?>"></script>
<script src="<?=base_url('adminLTE/plugins/pdfmake/pdfmake.min.js')?>"></script>
<script src="<?=base_url('adminLTE/plugins/pdfmake/vfs_fonts.js')?>"></script>
<script src="<?=base_url('adminLTE/plugins/datatables-buttons/js/buttons.html5.min.js')?>"></script>
<script src="<?=base_url('adminLTE/plugins/datatables-buttons/js/buttons.print.min.js')?>"></script>
<script src="<?=base_url('adminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js')?>"></script>

</body>
</html>

<script>
  $(function () {
    $('.select2').select2();
  });

  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); 
    });
  }, 10000);
</script>