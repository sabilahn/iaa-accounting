<!-- footer -->
<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; 2018 <div class="bullet"></div> Design By Bootstrap
    </div>
</footer>
<!-- /footer -->
</div>
</div>

<!-- General JS Scripts -->
<script src="<?= base_url('assets/stisla/vendors/popper.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/tooltip.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/nicescroll/jquery.nicescroll.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/build/js/stisla.js') ?>"></script>

<!-- JS Libraries -->
<script src="<?= base_url('assets/stisla/vendors/simple-weather/jquery.simpleWeather.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/chart.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/jqvmap/dist/jquery.vmap.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/jqvmap/dist/maps/jquery.vmap.world.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/summernote/summernote-bs4.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/chocolat/dist/js/jquery.chocolat.min.js') ?>"></script>

<script src="<?= base_url('assets/stisla/vendors/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/datatables/DataTables/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/datatables/Select-1.2.4/js/dataTables.select.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/jquery-ui/jquery-ui.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/izitoast/js/iziToast.min.js') ?>"></script>

<!-- Page Specific JS File -->
<script src="<?= base_url('assets/stisla/build/js/page/index-0.js') ?>"></script>
<script src="<?= base_url('assets/stisla/build/js/page/bootstrap-modal.js') ?>"></script>
<script src="<?= base_url('assets/stisla/build/js/page/modules-datatables.js') ?>"></script>
<script src="<?= base_url('assets/stisla/build/js/page/modules-toastr.js') ?>"></script>

<!-- Template JS File -->
<script src="<?= base_url('assets/stisla/build/js/scripts.js') ?>"></script>
<script src="<?= base_url('assets/stisla/build/js/custom.js') ?>"></script>

<!-- JS input Libraries -->
<script src="<?= base_url('assets/stisla/vendors/cleave-js/dist/cleave.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/cleave-js/dist/addons/cleave-phone.us.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/jquery-pwstrength/jquery.pwstrength.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/select2/dist/js/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/stisla/vendors/jquery-selectric/jquery.selectric.min.js') ?>"></script>
<script>
    $(function() {
        setTimeout(function() {
            $('.alert.alert-dismissible').fadeOut(400, function() {
                $(this).alert('close');
            });
        }, 3000);

        function formatRibuan(value) {
            var raw = String(value).replace(/\D/g, '');
            if (!raw) {
                return '';
            }
            if (raw.length > 1) {
                raw = raw.replace(/^0+/, '') || '0';
            }
            return raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        $('.currency-input').each(function() {
            if ($(this).val() !== '') {
                $(this).val(formatRibuan($(this).val()));
            }
        });

        $(document).on('input', '.currency-input', function() {
            $(this).val(formatRibuan(this.value));
        });

        $(document).on('submit', 'form', function() {
            $(this).find('.currency-input').each(function() {
                $(this).val($(this).val().replace(/\./g, ''));
            });
        });
    });
</script>
</body>

</html>

