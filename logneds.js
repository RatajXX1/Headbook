

function set_up_register() {
    let year_select = document.querySelector("#register_page_birth_year")
    let year_date = new Date().getFullYear()
    for (var i = 0; i <= 90; i++) {
        var option = document.createElement("option")
        option.value = year_date - i
        option.text = year_date - i
        year_select.append(option)
    }
}

function set_up_day(count_d) {
    let day_select = document.querySelector("#register_page_birth_day")
    var x, L = day_select.options.length - 1;
    for(x = L; x >= 0; x--) {
        day_select.remove(x);
    }
    for (var i = 1; i <= count_d; i++) {
        var option = document.createElement("option")
        option.value = i
        option.text = i
        day_select.append(option)
    }
}

function make_push(texts) {
    let push_pop = document.querySelector(".alert_box_login_page")
    if (push_pop.style.display != "block") {
        document.querySelector("#alert_box_login_page_text_a").innerHTML = texts
        push_pop.classList.add("show_dow_cl")
        push_pop.style.display = "block"
    }
    else {
        push_pop.classList.remove("show_dow_cl")
        push_pop.classList.add("show_up_cl")
        function hande_animation(e) {
            push_pop.classList.remove("show_up_cl")
            document.querySelector("#alert_box_login_page_text_a").innerHTML = texts
            push_pop.classList.add("show_dow_cl")
            push_pop.removeEventListener("animationend", hande_animation)
        }
        push_pop.addEventListener("animationend", hande_animation)
    }
}

function remove_push() {
    let push_pop = document.querySelector(".alert_box_login_page")
    if (push_pop.style.display != "none") {
        push_pop.classList.remove("show_dow_cl")
        push_pop.classList.add("show_up_cl")
        function hande_animation(e) {
            push_pop.classList.remove("show_up_cl")
            push_pop.removeEventListener("animationend", hande_animation)
            push_pop.style.display = "none"
        }
        push_pop.addEventListener("animationend", hande_animation)
    }
}

function make_post(url, data, succes_collback, error_coolback) {
    var ajax = new XMLHttpRequest()
    ajax.open("POST", url, true)
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                succes_collback(ajax.responseText)
            }
            else {
                error_coolback(ajax.responseText)
            }
        }
    }
    ajax.send(data)
}

function month_to_number(month) {
    switch (month.toLowerCase()) {
        case "jan":
            return "1"
        case "feb":
            return "2"
        case "mar":
            return "3"
        case "apr":
            return "4"
        case "may":
            return "5"
        case "jun":
            return "6"
        case "jul":
            return "7"
        case "aug":
            return "8"
        case "sep":
            return "9"
        case "oct":
            return "10"
        case "nov":
            return "11"
        case "dec":
            return "12"
    }
}

function set_up_register_panel() {
    let btn_radio_me = document.querySelector(".btn_1_radio_0")
    let btn_radio_fe = document.querySelector(".btn_1_radio_1")

    btn_radio_me.addEventListener("click", function(e) {
        if (!this.classList.contains("checked_radio_ge")) {
            this.classList.add("checked_radio_ge")
            if (btn_radio_fe.classList.contains("checked_radio_ge")) {
                btn_radio_fe.classList.remove("checked_radio_ge")
            }
            document.querySelector("#Gender_male_radio").checked = true
        }
    })

    btn_radio_fe.addEventListener("click", function(e) {
        if (!this.classList.contains("checked_radio_ge")) {
            this.classList.add("checked_radio_ge")
            if (btn_radio_me.classList.contains("checked_radio_ge")) {
                btn_radio_me.classList.remove("checked_radio_ge")
            }
            document.querySelector("#Gender_female_radio").checked = true
        }
    })

    let btn_reg = document.querySelector(".register_page_submit")
    
    let name_inp = document.querySelector(".register_login_inpute_1")
    let surrname_inp = document.querySelector(".register_login_inpute_2")
    
    let ph_em_inp = document.querySelector(".login_page_email_input")
    let password_inp = document.querySelector(".login_page_password_input")

    let ge_male = document.querySelector("#Gender_male_radio")
    let ge_female = document.querySelector("#Gender_female_radio")

    let b_day = document.querySelector("#register_page_birth_day")
    let b_month = document.querySelector("#register_page_birth_month")
    let b_year = document.querySelector("#register_page_birth_year")

    btn_reg.addEventListener("click", function(e) {
        if (name_inp.value.trim().length == 0 || surrname_inp.value.trim().length == 0) {
            make_push("You need Name and surrname to make account !")   
        }
        else {
            if (ph_em_inp.value.trim().length == 0) {
                make_push("You need mobile phone number or e-mail !")
            }
            else {
                var vail_email = false
                if (isNaN(ph_em_inp.value.trim())) {
                    // email
                    function validateEmail(email) {
                        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                        return re.test(String(email).toLowerCase());
                    }
                    if (validateEmail(ph_em_inp.value.trim())) {
                        vail_email = true
                    }
                    else {
                        make_push("E-mail adress is not valid")
                        return
                    }
                }
                else {
                    // phone
                    vail_email = true
                }
                if (vail_email){
                    if (password_inp.value.trim().length < 8) {
                        make_push("Password must have eight signs!")
                    }
                    else {
                        if (b_day.value.toString().toLowerCase() != "day" && b_month.value.toString().toLowerCase() != "month" && b_year.toString().toString().toLowerCase() != "year" ) {
                            var birth_day = b_day.value.toString() + "-" + month_to_number(b_month.value.toString()) + "-" + b_year.value.toString()
                            if (ge_male.checked == true || ge_female.checked == true) {
                                var gender = ""
                                if (ge_male.checked) {
                                    gender = "male"
                                }
                                else {
                                    gender = "female"
                                }
                                make_post("/login.php", "Method=register&Name=&Surrname=rataj&Login="+ph_em_inp.value.trim()+"&Password="+password_inp.value.trim()+"&Birthday="+birth_day+"&Gender="+gender, function(t) {
                                    remove_push()
                                    window.location.href = "/headbook/index.php"
                                }, function(t) {
                                    make_push(t)
                                })
                            }
                            else {
                                make_push("You must select your gender !")
                            }
                        }
                        else {
                            make_push("You need select you birhday !")
                        }
                    }
                }
                else {
                    make_push("E-mail adress or phone number is not valid!")
                }
            }
        }
    })
}

window.onload = function() {
    set_up_register()
    set_up_register_panel()
    set_up_day(31)
    let register_button = document.querySelector("#login_page_register")

    register_button.addEventListener("click", function() {
        document.querySelector("#register_page_back").style.display = "block"
    })

    let register_close_button = document.querySelector("#register_exit_close_bt")

    register_close_button.addEventListener("click", function() {
        document.querySelector("#register_page_back").style.display = "none"
    })

    let login_button = document.querySelector("#login_page_login")

    login_button.addEventListener("click", function() {
        let login_text = document.querySelector("#login_input_login")
        let passw_text = document.querySelector("#password_input_login")
        if (login_text.value.trim().length == 0 || passw_text.value.trim().length == 0 ) {
            make_push("Login and passsword is need to login!")
        } else {
            make_post("/login.php", "Method=login&Login="+login_text.value.trim()+"&Password="+passw_text.value.trim(), function(t) {
                remove_push()
                window.location.href = "/headbook/index.php"
            }, function(t) {
                make_push(t)
            } )
        }
    })

    let month_select = document.querySelector("#register_page_birth_month")

    month_select.addEventListener("change", function(e) {    
        function if_year_is_() {
            let date_year = new Date().getFullYear()  
            if (date_year % 4 == 0) {
                return true
            }
            else {
                return false
            }
        }
        switch (e.target.value.toLowerCase()) {
            case "feb":
                if (if_year_is_() == true) {
                    set_up_day(29)
                }
                else {
                    set_up_day(28)
                }
                break
            case "apr":
                set_up_day(30)
                break
            case "jun":
                set_up_day(30)
                break
            case "sep":
                set_up_day(30)
                break
            case "nov":
                set_up_day(30)
                break
            default:
                set_up_day(31)
                break
        }
    })
}