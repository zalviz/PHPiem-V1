<div class="row">
	<div class="col-xs-12">
		<?= form_open($formaction, array('id' => @$idform, 'class' => 'form form-horizontal form-label-left', 'data-parsley-validate')); ?>
			<?= $content; ?>
		</form>
	</div>
</div>