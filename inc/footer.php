<script src="<?php echo BASE_URL?>ass/js/jquery-3.4.1.min.js"></script>
<script src="<?php echo BASE_URL?>ass/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL?>ass/js/croppie.js"></script>
<script src="<?php echo BASE_URL?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo BASE_URL?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo BASE_URL?>vendor/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo BASE_URL?>vendor/datatables/responsive.bootstrap4.min.js"></script>
<script>
    $('#dataTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
</script>

