<link href="<?php echo base_url(); ?>css/image-picker.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/image-picker.js"></script>

<select class="image-picker show-html">
	<option data-img-src="https://dummyimage.com/100x75/000/fff" value="1">Cute Kitten 1</option>
	<option data-img-src="https://dummyimage.com/100x75/000/fff" value="2">Cute Kitten 2</option>
	<option data-img-src="https://dummyimage.com/100x75/000/fff" value="3">Cute Kitten 3</option>
</select>

<script>
	$("select").imagepicker();
</script>