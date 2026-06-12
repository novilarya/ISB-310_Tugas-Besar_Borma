document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-edit-promo-trigger').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var d = this.dataset;
            document.getElementById('eNama').value      = d.nama || '';
            document.getElementById('eKode').value      = d.kode || '';
            document.getElementById('ePemicu').value    = d.pemicu || '';
            document.getElementById('eHadiah').value    = d.hadiah || '';
            document.getElementById('eQtyPemicu').value = d.qtyPemicu || '';
            document.getElementById('eQtyHadiah').value = d.qtyHadiah || '';
            document.getElementById('ePotongan').value  = d.potongan || '';
            document.getElementById('eMin').value       = d.min || '';
            document.getElementById('eMax').value       = d.max || '';
            document.getElementById('eKuota').value     = d.kuota || '';
            document.getElementById('eMulai').value     = d.mulai || '';
            document.getElementById('eBerakhir').value  = d.berakhir || '';
            document.getElementById('editPromoForm').action = d.action || '';
        });
    });
});
