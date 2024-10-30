		
    	<div class="wpcm-row">
    		<div class="wpcm-col-md-6">
    			<el-date-picker style="width: 100%;" v-if="recurring===true"  v-model="extras.recuring_start" type="date" placeholder="Starting Date">
    			</el-date-picker>
    		</div>
	    	<div class="wpcm-col-md-6">
		    	<el-select style="width: 100%;" v-if="recurring===true"  v-model="extras.recuring_ending" size="large">
		    		<el-option key="selectending" value="selectending" label="Ending"></el-option>
					<el-option key="cancel" value="cancel" label="When I cancel it"></el-option>
					<el-option key="number_gifts" value="number_gifts" label="After number of gifts"></el-option><!-- 
					<el-option key="specific_date" value="specific_date" label="On a specific date"></el-option> -->
				</el-select>
			</div>
			<div class="wpcm-col-md-6">
				<el-date-picker style="width: 100%; margin-top:10px" v-if="extras.recuring_ending==='specific_date'"  v-model="extras.ending_date" type="date" placeholder="Ending Date">
		    	</el-date-picker>
		    </div>
	    	<div class="wpcm-col-md-6">
	    		<input style="width: 100%; margin-top:10px"  type="number" v-if="extras.recuring_ending==='number_gifts'" v-model="extras.gifts_number" placeholder="e.g. 1-1000">
	    	</div>
	    </div>