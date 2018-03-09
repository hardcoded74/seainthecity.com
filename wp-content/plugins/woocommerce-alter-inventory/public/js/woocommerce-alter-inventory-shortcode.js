jQuery(document).ready(function () {
    if (jQuery(".alter_inventory_page")[0]) {
        jQuery("#variants_table_wrap, .product_at_tab .prev-next-posts a").hide();
        //jQuery("#products_table_wrap_at").hide();
        jQuery(".variants_at_tab").on("click", function () {
            jQuery("#variants_table_wrap").show();
            jQuery("#products_table_wrap_at").hide();
            jQuery(this).toggleClass("active");
            jQuery(".product_at_tab").removeClass("active")
        });
        jQuery(".product_at_tab, .product_at_tab .prev-next-posts a").on("click", function () {
            jQuery("#products_table_wrap_at").show();
            jQuery("#variants_table_wrap").hide();
            jQuery(this).toggleClass("active");
            jQuery(".variants_at_tab").removeClass("active")
        });
        jQuery("#reviews").hide();
        jQuery('.alter_inventory_page input[type="number"]').bootstrapNumber({
            upClass: 'up_tckt',
            downClass: 'dwn_tckt'
        });
        // DataTable
        var table = $('.pagination_at').DataTable({
            "lengthMenu": [[3, 6, 12, 25, 50, -1], [3, 6, 12, 25, 50, "All"]]
        });

        // Apply the search
        table.columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                            .search(this.value)
                            .draw();
                }
            });
        });
    }
});
                    

