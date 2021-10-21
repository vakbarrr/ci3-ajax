var base_url = window.location.origin;
var user_url = window.location.origin+'/user';

function addtoWishlist(property_id, el){
	$.ajax({
		url: base_url+'/wishlist/validate',
		type: 'POST',
		dataType: 'json',
		data: {property_id: property_id},
		success: function(json){
			if(json['add']){
				el.firstElementChild.className = 'fa fa-heart';
                el.classList.add('fav');
			}else if(json['remove']){
				el.firstElementChild.className = 'fa fa-heart-o';
                el.classList.remove('fav');
			}else{
				window.location = user_url;
			}

            // if('getWishlist' in Obj){
             if (typeof getWishlist === 'function') {
                    // function exists
                    getWishlist();
                }
		}
	});

}
/**
 * [setCookie description]
 * @param {[type]} cname  [description]
 * @param {[type]} cvalue [description]
 * @param {Number} exdays [description]
 */
function setCookie(cname, cvalue, exdays = 1) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * [getCookie description]
 * @param  {[type]} cname [description]
 * @return {[type]}       [description]
 */
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
/**
 * [checkCompare description]
 * @return {[type]} [description]
 */
function checkCompare() {
    var compare = getCookie("compare");
    if (compare == "") {

        var compare = '';
        setCookie("compare", compare);
        // compare.push("Kiwi");
    } else {
        var compare = compare.split(',');
        var compare = Array.from(new Set(compare));
        setCookie("compare", compare.join());
    }

    var totalcom = document.getElementById('total-compare');
    totalcom.innerHTML = compare.length;

    if(compare.length > 0){
        totalcom.closest('.list-total-compare').classList.add('active');

    }else{
        totalcom.closest('.list-total-compare').classList.remove('active');
    }

    // console.log(compare);
    for (var i = 0; i < compare.length; i++) {
        var el = document.getElementById('Compare-' + compare[i]);

        if (el) {
            if (el.checked == false) {
                el.checked = true;

            }
        }
    }
}

/**
 * [setCompare description]
 * @param {[type]} el [description]
 */
function setCompare(el) {
    // console.log(el.checked);

    var compare = getCookie('compare');

    var compare = compare.split(",");

    if (el.checked == true) {
        compare.push(el.value);
    } else {
        var index = compare.indexOf(el.value);

        //hapus id dari compare
        compare.splice(compare.indexOf(el.value), 1);
        console.log(index);
    }

    //hapus array yg kosong
    var compare = compare.filter(function(el) {
        return el;
    });

    //hanya uniq array
    var compare = Array.from(new Set(compare))

    setCookie("compare", compare.join());

    checkCompare();
}

