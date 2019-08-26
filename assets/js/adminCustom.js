

$(function () {
	$(document).ready(function () {
		$('.delcat').click(function () {
			var id = $(this).data('id');
			var text = $(this).data('text');
			$.ajax({
				type : 'POST',
				url: surl+'admin/deleteCategory',
				data: {
					id:id,
					text:text
				},
				success:function (data) {
					var ndata = JSON.parse(data);
					if(ndata.return == true) {
						$('.error').text(ndata.message);
						$('.ccat'+id).fadeOut();
					}
					else if(ndata.return == false){
						$('.error').text(ndata.message);
					}
					else{
						$('.error').text('Something went wrong.');
					}
				}
				,
				error:function () {
					$('.error').text('Something went wrong.');
				}

			});
		});
		$('.delproduct').click(function () {
			var id = $(this).data('id');
			var text = $(this).data('text');
			$.ajax({
				type : 'POST',
				url: surl+'admin/deleteProduct',
				data: {
					id:id,
					text:text
				},
				success:function (data) {
					var ndata = JSON.parse(data);
					if(ndata.return == true) {
						$('.error').text(ndata.message);
						$('.ccat'+id).fadeOut();
					}
					else if(ndata.return == false){
						$('.error').text(ndata.message);
					}
					else{
						$('.error').text('Something went wrong.');
					}
				}
				,
				error:function () {
					$('.error').text('Something went wrong.');
				}

			});
		});
        $('.delmodel').click(function () {
            var id = $(this).data('id');
            var text = $(this).data('text');
            $.ajax({
                type : 'POST',
                url: surl+'admin/deleteModel',
                data: {
                    id:id,
                    text:text
                },
                success:function (data) {
                    var ndata = JSON.parse(data);
                    if(ndata.return == true) {
                        $('.error').text(ndata.message);
                        $('.ccat'+id).fadeOut();
                    }
                    else if(ndata.return == false){
                        $('.error').text(ndata.message);
                    }
                    else{
                        $('.error').text('Something went wrong.');
                    }
                }
                ,
                error:function () {
                    $('.error').text('Something went wrong.');
                }

            });
        });


		$(function () {
			$('.add_spec').click(function () {
				var sp_count = $('.sp_cn').length;
				var itmes  = "";
				itmes +="<div class='form-group contspecval rmov"+sp_count+"'>";
				itmes +="<input type='text' name='so_val[]'  class='form-control sp_cn' placeholder='Spec value'>";
				itmes +="<a href='javascript:void(0)' class='remov_spec' data-id="+sp_count+">-</a>";
				itmes +="</div>";
				console.log(sp_count);
                if (sp_count <=5) {
					$('.htmlitmes').append(itmes)
                }



            });
        });

		$('body').on("click","a.remov_spec",function () {
			var curnt = $(this).data('id');
			console.log(curnt);
			$('.rmov'+curnt).remove();

        });

        $('.specNow').click(function () {
            var id = $(this).data('id');
            var text = $(this).data('text');
            $.ajax({
                type : 'POST',
                url: surl+'admin/deleteSpec',
                data: {
                    id:id,
                    text:text
                },
                success:function (data) {
                    var ndata = JSON.parse(data);
                    if(ndata.return == true) {
                        $('.error').text(ndata.message);
                        $('.ccat'+id).fadeOut();
                    }
                    else if(ndata.return == false){
                        $('.error').text(ndata.message);
                    }
                    else{
                        $('.error').text('Something went wrong.');
                    }
                }
                ,
                error:function () {
                    $('.error').text('Something went wrong.');
                }

            });
        });


	});//ready ends here
});
