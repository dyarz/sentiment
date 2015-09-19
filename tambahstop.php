

	<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Tambah Stopword</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="formstop" action="ai.php" method="post">
                            <label>Kata Stopword</label> <input type="text" name="stopword" id="stopword" autocomplete="off" class="inputSuccess">
                            <button type="submit" class="btn btn-primary" name="tambahstop" id="tambahstop">Simpan</button>
                        </form>
					</div>
				</div><!--/span-->

			</div><!--/row-->
<script>
		
		$.validator.setDefaults({
			submitHandler: function() {
				
				form.submit();
			}
		});
		$().ready(function() {
		
			$( "#formstop" ).validate({
				rules: {
					stopword: {
						required: true,
						remote: { 
							url: "checkkata.php", 
							type: "post",
							data:{
								stopword: function(){
								  return $('#formstop :input[name="stopword"]').val();
								},
								
							 },
							
							
						} 
					},
				
				},
				 messages: {
					stopword: {
						required:"Kata Stopword harus diisi",
						remote: jQuery.validator.format("kata {0} sudah ada.")
					}
				}
			
			});
		});	
</script>