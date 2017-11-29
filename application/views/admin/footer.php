			
				</div>
			</div>
			<footer>
				<div class="pull-right">PHP Indonesia Event Management powered by <a href="https://www.pradesga.com">Pradesga Indonesia</a></div>
				<div class="clearfix"></div>
			</footer>
		</div>
	</div>

<?= @$jsfiles; ?>

<?php if ( isset($docreadyscript) || isset($jsscript) ) : ?>

<script type="text/javascript">
<?= @$jsscript; ?>

<?php if ( isset($docreadyscript) ) : ?>

$(document).ready(function() {
<?= @$docreadyscript; ?>
});

<?php endif; ?>
</script>

<?php endif ?>
</body>
</html>