var active_page = 1
var active_nv_other = false

var NAME_profile, SURRNAME_PROFILE, Birthday_PROFILE, Gender_PROFILE

var last_profile = 0

function remove_active_from_bt() {
    var btns = document.querySelectorAll("[id='navbar_icon']")
    btns.forEach((e) => {
        if (e.classList.contains("navbar_bt_activer")) {
            e.classList.remove("navbar_bt_activer")
        }
    })
}

function reset_all_view() {
    var views = [document.querySelector("#headbook_main_view"), document.querySelector("#headbook_profile_view"), document.querySelector("#headbook_search_view")]
    views.forEach(function(e) {
        if (e.style.display != "none") {
            e.style.display = "none"
        }
    })
}

function create_post_element(homade, texts, date, id=0) {
    var text = ` <div class="post_view_table">
            <div onclick="load_profile(${id})"    class="post_view_table_header">
                <div class="post_view_table_header_profile">
                    <img src="img/man.png">
                </div>
                <div class="post_view_table_header_profile_text">
                    <a>${homade}</a>
                    <br>
                    <a>${date}</a>
                </div>
            </div>
            <div class="post_view_table_text"> 
                ${texts}
            </div>
            <div class="post_view_table_footer">
                <div class="post_view_table_footer_line"></div>
                <div class="post_view_table_footer_buttons">
                    <div class="post_view_table_footer_buttons_btns">
                        <input type="button" value="Like it">
                    </div>
                    <div class="post_view_table_footer_buttons_btns">
                        <input type="button" value="Comment">
                    </div>
                    <div class="post_view_table_footer_buttons_btns">
                        <input type="button" value="Share">
                    </div>
                </div>
            </div>
        </div> `
    var divs = document.createElement("div")
    divs.innerHTML = text.trim()
    return divs.firstChild
}

function make_ajax(url, data, succes_collback, error_coolback, method="POST") {
    var ajax = new XMLHttpRequest()
    ajax.open(method, url, true)
    if (method == "POST") {
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    }
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

function load_profile(id ) {
    last_profile = id
    if (id == 0) {
        document.querySelector("#edit_profile").style.display = "block"
        if (document.querySelector("#add_to_friend").style.display != "none") {
            document.querySelector("#add_to_friend").style.display = "none"
        }
        document.querySelector("#Name_and_Surr_profile").innerHTML = NAME_profile + " " + SURRNAME_PROFILE
        make_ajax("post.php?page=0", "", function(t) {
            var t = t.split("|")
            t.forEach(function(e) {
                if (e != "") {
                    var jso = JSON.parse(e)
                    var ele = create_post_element(jso["relname"], jso["text"], jso["time"], id=jso["from"])
                    document.querySelector("#headbook_profile_view_main").appendChild(ele)
                }
            })
        }, function(t) {
            console.log(T)
        }, method="GET")
    } else {
        document.querySelector("#add_to_friend").style.display = "block"
        if (document.querySelector("#edit_profile").style.display != "none") {
            document.querySelector("#edit_profile").style.display = "none"
        }
        make_ajax("user.php?User_ID=" + id.toString() , "" ,function(t) {
            var t = JSON.parse(t)
            document.querySelector("#Name_and_Surr_profile").innerHTML = t["name"] + " " + t["surrname"]
        }, function(t) {
            console.log(T)
        }, method="GET")
        make_ajax("post.php?page=0", "", function(t) {
            var t = t.split("|")
            t.forEach(function(e) {
                if (e != "") {
                    var jso = JSON.parse(e)
                    var ele = create_post_element(jso["relname"], jso["text"], jso["time"], id=jso["from"])
                    document.querySelector("#headbook_profile_view_main").after(ele)
                }
            })
        }, function(t) {
            console.log(T)
        }, method="GET")
    }
}

function hard_active_page(id) {
    if (id == 1) {
        document.querySelector("#headbook_main_view").style.display = "block"
    } else if (id == 0) {
        load_profile(last_profile)
        document.querySelector("#headbook_profile_view").style.display = "block"
    } else if (id == -1) {
        document.querySelector("#headbook_search_view").style.display = "block"
    }
}

function set_up_bt() {
    let btn_1 = document.querySelector(".nbt1")
    btn_1.addEventListener("click", function(e) {
        remove_active_from_bt()
        document.querySelector(".nv_bt_home").classList.add("navbar_bt_activer")
        let show_ds = document.querySelector("#headbook_main_view")
        if (active_page != 1 && show_ds.style.display != "block") {
            active_page = 1
            reset_all_view()
            show_ds.style.display = "block"
        }
    })
    let btn_2 = document.querySelector(".nbt2")
    btn_2.addEventListener("click", function(e) {
        remove_active_from_bt()
        document.querySelector(".nv_bt_watch").classList.add("navbar_bt_activer")
        let show_ds = null
        // TODO: skonczyc 
        if (active_page != 2 ) {
            active_page = 2
            reset_all_view()
        }
    })
    let btn_3 = document.querySelector(".nbt3")
    btn_3.addEventListener("click", function(e) {
        remove_active_from_bt()
        document.querySelector(".nv_bt_shop").classList.add("navbar_bt_activer")
        let show_ds = null
        // TODO: skonczyc 
        if (active_page != 3 ) {
            active_page = 3
            reset_all_view()
        }
    })
    let btn_4 = document.querySelector(".nbt4")
    btn_4.addEventListener("click", function(e) {
        remove_active_from_bt()
        document.querySelector(".nv_bt_grup").classList.add("navbar_bt_activer")
        let show_ds = null
        // TODO: skonczyc 
        if (active_page != 4 ) {
            active_page = 4
            reset_all_view()
        }
    })
    document.querySelector(".nv_bt_home").classList.add("navbar_bt_activer")
    let btn_5 = document.querySelector(".nbt5")
    btn_5.addEventListener("click", function(e) {
        let showdd = document.querySelector("#view_show_post_main")
        if (!active_nv_other) {
            reset_all_view()
            document.querySelector(".nv_bt_menu").classList.add("navbar_bt_activer")
            showdd.style.display = "block"
            showdd.style.top = "60px"
            showdd.style.height = "90%"
            showdd.style.width = "90%"
            showdd.style.margin = "0"
            document.querySelector("#view_show_post_main_list_footer").style.display = "none"
            document.body.appendChild(showdd)
            active_nv_other = true
        }
        else {
            document.querySelector(".nv_bt_menu").classList.remove("navbar_bt_activer")
            showdd.style.display = ""
            showdd.style.top = "60px"
            showdd.style.left = "0px"
            showdd.style.float = "left"
            showdd.style.height = "92%"
            showdd.style.width = "400px"
            showdd.style.marginTop = "15px"
            hard_active_page(active_page)
            document.querySelector("#view_show_post_main_list_footer").style.display = "block"
            document.querySelector("#headbook_view_show").insertBefore(showdd, document.querySelector("#headbook_view_show_post"))
            active_nv_other = false
            
        }
    })

    let profil_bt_1 = document.querySelector("#headbook_main_navbar_options_name")
    let profil_bt_2 = document.querySelector(".bt_profile_main") 

    profil_bt_1.addEventListener("click", function() {
        remove_active_from_bt()
        reset_all_view()
        active_page = 0
        document.querySelector("#headbook_profile_view").style.display = "block"
        load_profile(0)
    })

    profil_bt_2.addEventListener("click", function() {
        if (active_nv_other) {
            let showdd = document.querySelector("#view_show_post_main")
            document.querySelector(".nv_bt_menu").classList.remove("navbar_bt_activer")
            showdd.style.display = ""
            showdd.style.top = "60px"
            showdd.style.left = "0px"
            showdd.style.float = "left"
            showdd.style.height = "92%"
            showdd.style.width = "400px"
            showdd.style.marginTop = "15px"
            hard_active_page(active_page)
            document.querySelector("#view_show_post_main_list_footer").style.display = "block"
            document.querySelector("#headbook_view_show").insertBefore(showdd, document.querySelector("#headbook_view_show_post"))
            active_nv_other = false
        }
        remove_active_from_bt()
        reset_all_view()
        active_page = 0
        document.querySelector("#headbook_profile_view").style.display = "block"
        load_profile(0)
    })
}

function show_createPost() {
    let btn = document.querySelector("#table_show_create_post_button")
    btn.addEventListener("click", function(e) {
        document.querySelector("#headbook_add_create_post").style.display = "block"
    })
    let btn_X = document.querySelector("#headbook_add_create_post_close")
    btn_X.addEventListener("click", function(e) {
        document.querySelector("#headbook_add_create_post").style.display = "none"
    })
}

var div_empty = true
function check_post_create_div() {
    let div_ed = document.querySelector("#create_post_pop_editable_div")
    let text = "<h1>What you thinking, Michal ?</h1>"
    div_ed.innerHTML = text
    div_ed.addEventListener("click", function(e) {
        if (div_empty) {
            div_ed.innerHTML = ""
            div_empty = false
        }
    })
    div_ed.addEventListener("focus", function(e) {
        if (div_empty == false) {
            if (div_ed.textContent.trim().length == 0) {
                div_empty = true
                div_ed.innerHTML = "<h1>What you thinking, Michal ?</h1>"
            }
        }
    })
    div_ed.addEventListener("blur", function(e) {
        if (div_empty == false) {
            if (div_ed.textContent.trim().length == 0) {
                div_empty = true
                div_ed.innerHTML = "<h1>What you thinking, Michal ?</h1>"
            }
        }
    })
}





function send_json(url, data, succes_collback, error_coolback) {
    var ajax = new XMLHttpRequest()
    ajax.open("POST", url, true)
    ajax.setRequestHeader("Content-type", "application/json")
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            if (ajax.status == 200 ) {
                succes_collback(ajax.responseText)
            } else {
                error_coolback(ajax.responseText)
            }
        }
    }
    ajax.send(data)
}

function set_up_info() {
    let on_name = document.querySelectorAll("[id='Name_req_it']")
    let on_name_surr = document.querySelectorAll("[id='Name_Surr_req_it']")
    
    function set_your_info(Name, Surrname) {
        on_name.forEach(function(e) {
            e.innerHTML = Name
        })

        on_name_surr.forEach(function(e) {
            e.innerHTML = Name + " " + Surrname
        })
    }
    
    make_ajax("user.php?User_ID=0", "", function(t) {
        var resp = JSON.parse(t)
        set_your_info(resp["name"], resp["surrname"])
        NAME_profile = resp["name"]
        SURRNAME_PROFILE = resp["surrname"]
        Birthday_PROFILE = resp["birhday"]
        Gender_PROFILE = resp["gender"]
    }, function(t) {
        set_your_info("Unknow", "Unknow")
        NAME_profile = "Unknow"
        SURRNAME_PROFILE = "Unknow"
        Birthday_PROFILE = "0-0-0000"
        Gender_PROFILE = "Unknow"
    }, method="GET")
}

var retu_arg = "";


function add_post(element) {
    // document.querySelector("#view_show_table").insertBefore(element, document.querySelector("#table_show_create_post"))
    document.querySelector("#table_show_create_post").after(element)
}

var load_more_main = true
var actual_page_main_post = 1

window.onscroll = function() {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight && load_more_main)    {
        if (active_page == 1) 
        {
            make_ajax("post.php?page="+actual_page_main_post.toString(), "", function(t) {
                if (t.length > 0) {
                    var resp = t.split("|")
                    // console.log(JSON.parse(resp[0]))
                    resp.slice().reverse().forEach(function(x) {
                        if (x != "") {
                            var jso = JSON.parse(x)
                            var post = create_post_element(jso["relname"], jso["text"], jso["time"], id=jso["from"])
                            document.querySelector("#view_show_table").appendChild(post)
                        }
                    })
                    if (resp.length < 15) {
                        load_more_main = false
                    } else {
                        actual_page_main_post += 1
                    }
                }
            }, function(t) {
                //location.reload()
            }, method="GET")
        }
    }
}

function load_post_new() {
    make_ajax("post.php?page=0", "", function(t) {
        if (t.length > 0) {
            var resp = t.split("|")
            // console.log(JSON.parse(resp[0]))
            resp.slice().reverse().forEach(function(x) {
                if (x != "") {
                    var jso = JSON.parse(x)
                    var post = create_post_element(jso["relname"], jso["text"], jso["time"], id=jso["from"])
                    add_post(post)
                }
            })
            if (resp.length < 15) {
                load_more_main = false
            }
        }
    }, function(t) {
        //location.reload()
    }, method="GET")
}

function send_post() {
    let save_btn = document.querySelector("#headbook_add_create_post_pop_bt_button")
    load_post_new()
    save_btn.addEventListener("click", function(e) {
        if (!div_empty && document.querySelector("#create_post_pop_editable_div").textContent.trim().length > 0) {
            document.querySelector("#headbook_add_create_post").style.display = "none"
            var sended_text = document.querySelector("#create_post_pop_editable_div").textContent
            send_json("post.php", JSON.stringify({"User_ID": 0, "text": sended_text, "location": "", "photos": ""}), function(t) {
                // On Succes
                // alert(t)
                var post = create_post_element(NAME_profile + " " + SURRNAME_PROFILE, sended_text, new Date().toLocaleTimeString())
                add_post(post)
                div_empty = true
                document.querySelector("#create_post_pop_editable_div").innerHTML = "<h1>What you thinking, Michal ?</h1>"
            }, function(t){
                // On error
                //location.reload()
            } )
        }
    })

}

function create_serach_element(name, id=0) {
    var text = `<div onclick="load_profile(${id})" class="search_score">
        <div class="search_score_profile">
            <img src="img/man.png">
        </div>
        <div class="search_score_profile_name">
            <a>${name}</a>
        </div>
    </div>`
    var divs = document.createElement("div")
    divs.innerHTML = text.trim()
    return divs.firstChild
}


mobile_Search = false 

function serach() {
    let search_menu = document.querySelector("#headbook_search_view")
    
    document.querySelector("#headbook_main_navbar_serach_bar").addEventListener("click", function(e) {
        if (document.body.scrollWidth < 750) {
            if (!mobile_Search) {
                reset_all_view()
                remove_active_from_bt()
                search_menu.style.display = "block"
                active_page = -1
                document.querySelector("#headbooK_serach_bar").style.display = "block"
                document.querySelector(".headbook_search_type").style.display = "none"
                mobile_Search = true
                var btns = document.querySelectorAll("[class='search_score']")
                btns.forEach((e) => {
                    e.style.display = "none"
                })
            } else {
                reset_all_view()
                search_menu.style.display = "none"
                active_page = 1
                document.querySelector("#headbooK_serach_bar").style.display = "none"
                document.querySelector(".headbook_search_type").style.display = "block"
                hard_active_page(1)
                mobile_Search = false
            }
        }
    })

    document.querySelector("#headbooK_serach_bar_input").addEventListener("keyup", function(e) {
        if (e.key == "Enter") {
            make_ajax("friends.php", "query=" + document.querySelector("#headbooK_serach_bar_input").value.replace(/ /g, "_"), function(t) {
                var jso = t.split("|")
                if (jso.length > 0) {
                    var btns = document.querySelectorAll("[class='search_score']")
                    btns.forEach((e) => {
                        e.parentNode.removeChild(e)
                    })
                    jso.forEach(function(e) {
                        if (e != "") {
                            var son = JSON.parse(e)
                            var eleme = create_serach_element(son["name"], ids=jso["ids"])
                            document.querySelector(".headbook_search_type").after(eleme)
                        }
                    })
                    document.querySelector("#headbooK_serach_bar").style.display = "none"
                    if (document.querySelector(".headbook_search_type").style.display != "block") {
                        document.querySelector(".headbook_search_type").style.display = "block"
                    }
                    document.querySelector("#headbooK_serach_bar_input").value = ""
                } 
            }, function(t) {
                console.log(t)
            }, method="POST")
        }
    })

    document.querySelector("#serach_text_type_bar").addEventListener("keyup", function(e) {
        if (document.body.scrollWidth > 750) {
            if (e.key === "Enter") {
                make_ajax("friends.php", "query=" + document.querySelector("#serach_text_type_bar").value.replace(/ /g, "_"), function(t) {
                    var jso = t.split("|")
                    if (jso.length > 0) {
                        var btns = document.querySelectorAll("[class='search_score']")
                        btns.forEach((e) => {
                            e.parentNode.removeChild(e)
                        })
                        jso.forEach(function(e) {
                            if (e != "") {
                                var son = JSON.parse(e)
                                var eleme = create_serach_element(son["name"], ids=jso["ids"])
                                document.querySelector(".headbook_search_type").after(eleme)
                            }
                        })
                        reset_all_view()
                        remove_active_from_bt()
                        search_menu.style.display = "block"
                        active_page = -1
                        if (document.querySelector(".headbook_search_type").style.display != "block") {
                            document.querySelector(".headbook_search_type").style.display = "block"
                        }
                        document.querySelector("#serach_text_type_bar").value = ""
                    } 
                }, function(t) {
                    console.log(t)
                }, method="POST")
            }
        }
    })
}   

function remove_searchbar() {
    if (document.body.scrollWidth > 750 && mobile_Search) {
        let search_menu = document.querySelector("#headbook_search_view")
        reset_all_view()
        search_menu.style.display = "none"
        active_page = 1
        document.querySelector("#headbooK_serach_bar").style.display = "none"
        document.querySelector(".headbook_search_type").style.display = "block"
        hard_active_page(1)
        mobile_Search = false
    }
}

window.onresize = function() {
    remove_searchbar()
    if (active_nv_other && document.body.scrollWidth >= 1350) {
        let showdd = document.querySelector("#view_show_post_main")
        document.querySelector(".nv_bt_menu").classList.remove("navbar_bt_activer")
        showdd.style.display = ""
        showdd.style.top = "60px"
        showdd.style.left = "0px"
        showdd.style.float = "left"
        showdd.style.height = "92%"
        showdd.style.width = "400px"
        showdd.style.marginTop = "15px"
        hard_active_page(active_page)
        document.querySelector("#view_show_post_main_list_footer").style.display = "block"
        document.querySelector("#headbook_view_show_post").insertBefore(showdd, document.querySelector("#view_show_table"))
        active_nv_other = false
    } else if (active_page == 0 && document.body.scrollWidth >= 1350){
        let showdd = document.querySelector("#view_show_post_main")
        document.querySelector(".nv_bt_menu").classList.remove("navbar_bt_activer")
        showdd.style.display = ""
        showdd.style.top = "60px"
        showdd.style.left = "0px"
        showdd.style.float = "left"
        showdd.style.height = "92%"
        showdd.style.width = "400px"
        showdd.style.marginTop = "15px"
        hard_active_page(active_page)
        document.querySelector("#view_show_post_main_list_footer").style.display = "block"
        document.querySelector("#headbook_view_show_post").insertBefore(showdd, document.querySelector("#view_show_table"))
        active_nv_other = false
    }
}

window.onload = function() {
    set_up_info()
    remove_active_from_bt()
    set_up_bt() 
    show_createPost()
    check_post_create_div()
    send_post()
    serach()    
}