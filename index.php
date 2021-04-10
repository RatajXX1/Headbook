<!DOCKTYTPE html>
<html>
	<head>
		<title>HeadBook</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style/styles.css">
		<script src="js/logneds.js"></script>
	</head>
	<body>
		<div class="alert_box_login_page">
			<div class="alert_box_login_page_text">
				<a id="alert_box_login_page_text_a">ERROR! wrong password!ERROR! wrong password!ERROR! wrong password!ERROR! wrong password!</a>
			</div>
		</div>
		<div id="login_page">
			<div id="logo_box">
				<a>HeadBook</a>
				<p>Connect with friends and the world around you on Headbook.</p>
			</div>
			<div id="login_pop_page">
				<div class="login_page_input_border" id="login_input_login_border">
					<input class="intput_login_page" id="login_input_login" type="email" placeholder="E-mail or number phone" name="email" value="" required>
				</div>
				<div class="login_page_input_border" id="password_input_login_border">
					<input class="intput_login_page" id="password_input_login" type="password" placeholder="Password" name="password" required>
				</div>
				<input id="login_page_login" type="button" value="Log In" name="login">
				<a href="#Forgot_password" id="login_page_forgot">Forgot Password?</a>
				<div id="login_page_line"></div>
				<input id="login_page_register" type="button" value="Create new Account" name="register">
			</div>
		</div>
		<div id="register_page_back">
			<div id="register_page">
				<div id="register_page_header">
					<a>Sign up</a>
					<p>It’s quick and easy.</p>
					<dvi id="register_exit_close_bt">
						<svg id="register_exit" height="365.696pt" viewBox="0 0 365.696 365.696" width="365.696pt" xmlns="http://www.w3.org/2000/svg"><path d="m243.1875 182.859375 113.132812-113.132813c12.5-12.5 12.5-32.765624 0-45.246093l-15.082031-15.082031c-12.503906-12.503907-32.769531-12.503907-45.25 0l-113.128906 113.128906-113.132813-113.152344c-12.5-12.5-32.765624-12.5-45.246093 0l-15.105469 15.082031c-12.5 12.503907-12.5 32.769531 0 45.25l113.152344 113.152344-113.128906 113.128906c-12.503907 12.503907-12.503907 32.769531 0 45.25l15.082031 15.082031c12.5 12.5 32.765625 12.5 45.246093 0l113.132813-113.132812 113.128906 113.132812c12.503907 12.5 32.769531 12.5 45.25 0l15.082031-15.082031c12.5-12.503906 12.5-32.769531 0-45.25zm0 0"/></svg>
					</dvi>
				</div>
				<div id="register_page_line"></div>
				<div id="reigister_flex_inputs">
					<div id="register_name_inputs">
						<div class="register_intput_border register_page_input_back" id="login_input_login_border">
							<input class="intput_login_page register_login_inpute_1" id="login_input_login" type="text" placeholder="First name" name="fname" required>
						</div>
						<div class="register_intput_border register_page_input_back" id="password_input_login_border">
							<input class="intput_login_page register_login_inpute_2" id="password_input_login" type="text" placeholder="Last name" name="sname" required>
						</div>
					</div>
					<div class="login_page_input_border register_page_input_back" id="login_input_login_border">
						<input class="intput_login_page login_page_email_input" id="login_input_login" type="text" placeholder="Email or number phone" name="fname" required>
					</div>
					<div class="login_page_input_border register_page_input_back" id="password_input_login_border">
						<input class="intput_login_page login_page_password_input" id="password_input_login" type="password" placeholder="Password" name="sname" required>
					</div>
					<div id="register_birh_inputs">
						<a>Birthday</a>
						<div id="register_bith_selecteds">
							<div class="register_page_birth_month_border">
								<select id="register_page_birth_month">
									<option value="Month">Month</option>
									<option value="Jan">Jan</option>
									<option value="Feb">Feb</option>
									<option value="Mar">Mar</option>
									<option value="Apr">Apr</option>
									<option value="May">May</option>
									<option value="Jun">Jun</option>
									<option value="Jul">Jul</option>
									<option value="Aug">Aug</option>
									<option value="Sep">Sep</option>
									<option value="Oct">Oct</option>
									<option value="Nov">Nov</option>
									<option value="Dec">Dec</option>
								</select>
							</div>
							<div class="register_page_birth_month_border">
								<select id="register_page_birth_day">
									<option value="Day">Day</option>
								</select>
							</div>
							<div class="register_page_birth_month_border">
								<select id="register_page_birth_year">
									<option value="Year">Year</option>
								</select>
							</div>
						</div>
					</div>
					<div id="register_gender_check">
						<a>Gender</a>
						<div id="register_gender_inputs">
							<div class="register_gender_border btn_1_radio_0">
								<div class="register_gender_div_in">
									<a class="register_gender">Male</a>
									<input id='Gender_male_radio' type="radio" name="male" placeholder="Male" value="0" required>
								</div>
							</div>
							<div class="register_gender_border btn_1_radio_1">
								<div class="register_gender_div_in">
									<a class="register_gender">Female</a>
									<input id='Gender_female_radio' type="radio" name="male" placeholder="Male" value="1" required>
								</div>
							</div>
						</div>
					</div>
					<p id="register_info_faq">By clicking Sign Up, you agree to our Terms. Learn how we collect, use and share your data in our Data Policy and how we use cookies and similar technology in our Cookies Policy. You may receive SMS Notifications from us and can opt out any time.</p>
					<input class="register_page_submit" id="login_page_register" type="button" value="Sign Up" name="register">
				</div>
			</div>
		</div>
		
		<!-- <div id="login_page_footer">
			<div id="login_page_footer_words">
				<div id="login_page_footer_langs">
					<a>English (US)</a>
					<a>Polish</a>
					<a>Deutsh</a>
				</div>
				<div id="footer_line_login"></div>
				<a style="font-size: 10px;">HeadBook 2021 by RatajXX1</a>
			</div>
		</div> -->
	</body>
</html>
