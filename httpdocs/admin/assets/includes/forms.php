<style>
.checkbox-group > div {
float: left;
    min-width: 10em;
    width: 25%;
}

</style>
<div id="article_form_content">
	<form action="">
		<fieldset>
			<label for="textfield">Text Label <span class="required">*</span> </label>
			<input type="text" id="textfield" name="textfield" placeholder="This is a text field" />
		</fieldset>
		<fieldset>
			<label for="textarea">Textarea Label <span class="required">*</span></label>
			<textarea name="textarea" id="textarea" rows="10" placeholder="This is some generic textarea text"></textarea>
		</fieldset>
		<fieldset>
			<label for="selectinput">Select Label</label>
			<select name="selectinput" id="selectinput">
				<option value="option1">Option1</option>
				<option value="option2">Option2</option>
				<option value="option3">Option3</option>
				<option value="option4">Option4</option>
			</select>
		</fieldset>
		<fieldset>
			<label for="checkboxinputchecked">Checkbox Label - Checked</label>
			<input type="checkbox" id="checkboxinputchecked" name="checkboxinputchecked" checked />
		</fieldset>
		<fieldset>
			<label for="checkboxinput">Categories<span class="required">*</span></label>
			<div class="checkbox-group" style="position: relative; margin: 0px 20%; float: left; width: 90%;">
				<div><input type="checkbox" value="" id="checkbox_id" name="checkbox_name" /><label class="checkbox-label">Recipes</label></div>		
				<div><input type="checkbox" value="" id="checkbox_id" name="checkbox_name" /><label class = "checkbox-label">Quick & Easy</label></div>
				<div><input type="checkbox" value="" id="checkbox_id" name="checkbox_name" /><label class="checkbox-label">Party Time</label></div>
				<div><input type="checkbox" value="" id="checkbox_id" name="checkbox_name" /><label class = "checkbox-label">Healthy</label></div>
				<div><input type="checkbox" value="" id="checkbox_id" name="checkbox_name" /><label class="checkbox-label">Family</label></div>		
				<div><input type="checkbox" value="" id="checkbox_id" name="checkbox_name" /><label class = "checkbox-label">Reviews</label></div>
				<div><input type="checkbox" value="" id="checkbox_id" name="checkbox_name" /><label class="checkbox-label">Drinks</label></div>
				<div><input type="checkbox" value="" id="checkbox_id" name="checkbox_name" /><label class = "checkbox-label">Desserts</label></div>
				<div><input type="checkbox" value="" id="checkbox_id" name="checkbox_name" /><label class = "checkbox-label">Foodie Topics</label></div>
			</div>
		</fieldset>
		<fieldset>
			<label for="rotation_time">Radio Options</label>
			<div><input type="radio" value="1" id="cbRotationTimeYes" name="cbRotationTime" /><label class="radio-label">Yes</label></div>
			<div><input type="radio" value="0" id="cbRotationTimeNo" name="cbRotationTime" /><label class = "radio-label">No</label></div>
		</fieldset>
		<fieldset>
			<div class="btn-wrapper">
				<button type="submit">Submit</button>	
			</div>
		</fieldset>
	</form>
</div>