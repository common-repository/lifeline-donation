<?php 
$posts = get_posts(array('post_type' => 'custom_option', 'posts_per_page' => -1));
$projects = get_posts(array('post_type' => ['project', 'cause'], 'posts_per_page' => -1));

?>
<div class="text-center" v-if="post_id < 1">
	<div class="form-group">
		<label for="donation-purpose" class="mb-4 font-weight-bold"><?php esc_html_e('Where would you like to donate to?', 'lifeline-donation') ?></label>
		
		<div class="mb-4">
			<?php if( post_type_exists( 'project' ) && post_type_exists( 'cause' ) ) : ?>
				<el-radio v-model="extras.donation_purpose" @change="getData()" label="all_projects_causes" border><?php esc_html_e('All Projects & Charities', 'lifeline-donation') ?></el-radio>
			<?php endif; ?>

			<?php if( post_type_exists( 'project' ) ) : ?>
	            <el-radio v-model="extras.donation_purpose" @change="getData()" label="all_projects" border><?php esc_html_e('All Projects', 'lifeline-donation') ?></el-radio>
	        <?php endif; ?>

	        <?php if( post_type_exists( 'cause' ) ) : ?>
			    <el-radio v-model="extras.donation_purpose" @change="getData()" label="all_causes" border><?php esc_html_e('All Charities', 'lifeline-donation') ?></el-radio>
			<?php endif; ?>

		    <?php do_action('lifeline_donation/donation_template/general/donation_options') ?>

		    <el-radio v-model="extras.donation_purpose" label="custom" border><?php esc_html_e('Make my own selection', 'lifeline-donation') ?></el-radio>
		</div>
		
		<div class="mb-4 el-custom-select">
			<el-select 
			  v-model="extras.custom_donation_purpose"
			  v-if="extras.donation_purpose == 'custom'"
              filterable
              @change="getData()"
			  placeholder="<?php esc_html_e('Choose Custom Donation Options', 'lifeline-donation') ?>"
			  multiple
			  :style="{width: '66%'}"
			>
				<el-option-group label="<?php esc_html_e('Projects', 'lifeline-donation') ?>">
				<?php foreach($projects as $pos) : ?>
					<el-option value="<?php echo esc_attr($pos->ID) ?>" label="<?php echo esc_attr($pos->post_title) ?>"></el-option>
				<?php endforeach; ?>
				
				</el-option-group>
				
				
				<el-option-group label="<?php esc_html_e('Charities', 'lifeline-donation') ?>">
				<?php foreach($posts as $pos) : ?>
					<el-option value="<?php echo esc_attr($pos->ID) ?>" label="<?php echo esc_attr($pos->post_title) ?>"></el-option>
				<?php endforeach; ?>
				</el-option-group>

				<?php do_action('lifeline_donation/donation_template/general/other_donation_options') ?>

			</el-select>
		</div>
	</div>
</div>