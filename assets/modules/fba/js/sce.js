/*********************************************************************
* #### jQuery File Browser Awesome v0.2.0 ####
* Coded by Ican Bachors 2014.
* http://ibacor.com/labs/jquery-file-browser-awesome/
* Updates will be posted to this site.
*********************************************************************/
var h;
var curr_dir;

function getParameterByName(a) {
	a = a.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var b = new RegExp("[\\?&]" + a + "=([^&#]*)"),
		results = b.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "))
};

var fba = function(g) {
    if (g.host != undefined && g.api != undefined && g.host != '' && g.api != '') {
        var j = '<div class="col-md-4"><div class="fba_direktori"></div></div>' + '<div class="col-md-8"><div class="fba_read_file"><i class="fa fa-code"></i> <span id="rf"></span>';
				j+='<div class="btn-group pull-right"><button name="btn-save-fba" id="btn-save-fba" class="btn btn-success btn-xs" disabled><i class="fa fa-floppy-o"></i>&nbsp;Save File</button><button name="btn-del-fba" id="btn-del-fba" class="btn btn-danger btn-xs"  disabled><i class="fa fa-trash-o"></i>&nbsp;Del File</button><button name="btn-new-fba" id="btn-new-fba" class="btn btn-primary btn-xs"><i class="fa fa-file-code-o"></i>&nbsp;New File</button><button name="btn-new-folder-fba" id="btn-new-folder-fba" class="btn btn-info btn-xs"><i class="fa fa-folder-o"></i>&nbsp;New Folder</button></div>';
				j+='</div>' + '<textarea id="fba_text" name="fba_text"></textarea></div>',
        k = getParameterByName('path');
        $("#fba").html(j);
        if (k != '') {
            if (k.indexOf('.') === -1) {
                fba_direktori(k)
            } else {
                var l = k.substring(k.lastIndexOf('/') + 1),
                gehu = k.replace('/' + l, "");
                fba_direktori(gehu);
                fba_file(k)
            }
        } else {
            fba_direktori("")
        }
        h = CodeMirror.fromTextArea(document.getElementById("fba_text"), {
						mode: "application/x-httpd-php",
						matchBrackets: true,
						indentUnit: 2,
						indentWithTabs: true,
						styleActiveLine: true,
						lineNumbers: true,
						lineWrapping: true,
						theme:'blackboard',
						extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
						foldGutter: true,
						gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
        });
				
    } else {
        alert('Options required.')
    }

    function fba_direktori(e) {
			$("#rf").html('');
			
        $.ajax({
            type: "POST",
            url: g.host + g.api,
            data: 'path=' + e,
            crossDomain: false,
            dataType: "json"
        }).done(function(c) {
						curr_dir = c.curr_dir;
            if (c.status == 'success') {
                var r = "";
                r += '<div class="fba_header"><div>Name</div><div>Size</div><div>Last Modified</div></div>';
                r += '<div class="fba_body">';
                if (e != "") {
                    var d = e.split('/'),
                        ee = [];
                    for (i = 0; i < d.length - 1; i++) {
                        ee.push(d[i])
                    }
                    var f = (d.length > 1 ? ee.join('/') : '');
                    r += '<div class="fba_root"><i class="bsub fa fa-level-up" data-bsub="' + f + '" title="Up"></i> ' + e 
                };
								
                $.each(c.data, function(i, a) {
                    if (c.data[i].type == "dir") {
                        r += '<div class="fba_content"><div class="name"><span class="sub fa" data-sub="' + c.data[i].path + '"><i class="fa fa-folder"></i> ' + c.data[i].name + '</span></div><div class="size">' + c.data[i].items + ' items</div><div class="modif">' + c.data[i].modif + '</div></div>'
                    } else {
                        var b = fba_size(c.data[i].size);
                        var s = c.data[i].path.substr(c.data[i].path.lastIndexOf(".") + 1);
                        switch (s) {
                            case "html":
                                r += '<div class="fba_content"><div class="name"><span class="rfile fa" data-rfile="' + c.data[i].path + '"><i class="fa fa-html5"></i> ' + c.data[i].name + '</span></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>';
                                break;
                            case "php":
                                r += '<div class="fba_content"><div class="name"><span class="rfile fa" data-rfile="' + c.data[i].path + '"><i class="glyphicon glyphicon-fire"></i> ' + c.data[i].name + '</span></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>';
                                break;
                            case "js":
                                r += '<div class="fba_content"><div class="name"><span class="rfile fa" data-rfile="' + c.data[i].path + '"><i class="fa fa-jsfiddle"></i> ' + c.data[i].name + '</span></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>';
                                break;
                            case "css":
                                r += '<div class="fba_content"><div class="name"><span class="rfile fa" data-rfile="' + c.data[i].path + '"><i class="fa fa-css3"></i> ' + c.data[i].name + '</span></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>';
                                break;
                            case "txt":
                                r += '<div class="fba_content"><div class="name"><span class="rfile fa" data-rfile="' + c.data[i].path + '"><i class="fa fa-file-text-o"></i> ' + c.data[i].name + '</span></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>';
                            case "md":
                            case "asp":
                            case "aspx":
                            case "jsp":
                            case "py":
                                r += '<div class="fba_content"><div class="name"><span class="rfile fa" data-rfile="' + c.data[i].path + '"><i class="fa fa-file-text-o"></i> ' + c.data[i].name + '</span></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>';
                                break;
                            case "apk":
                                r += '<div class="fba_content"><div class="name"><a href="' + g.host + c.data[i].dir + '/' + c.data[i].path + '" target="_blank"><i class="fa fa-android"></i> ' + c.data[i].name + '</a></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>'
                                break;
                            case "pdf":
                                r += '<div class="fba_content"><div class="name"><a href="' + g.host + c.data[i].dir + '/' + c.data[i].path + '" target="_blank"><i class="fa fa-file-pdf-o"></i> ' + c.data[i].name + '</a></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>'
                                break;
                            default:
                                r += '<div class="fba_content"><div class="name"><a href="' + g.host + c.data[i].dir + '/' + c.data[i].path + '" target="_blank"><i class="fa fa-cloud-download"></i> ' + c.data[i].name + '</a></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>'
                        }
                    }
                });
                r += "</div>";
                $(".fba_direktori").html(r);
								disable_save_del();
                $(".sub").click(function() {
										h.setValue('');
										h.clearHistory();
                    var t = $(this).data("sub");
                    fba_direktori(t);
                    window.history.pushState(null, null, "?path=" + t);
                    return false
                });
                $(".bsub").click(function() {
										h.setValue('');
										//disable_save_del();
                    var t = $(this).data("bsub");
                    fba_direktori(t);
                    window.history.pushState(null, null, "?path=" + t);
                    return false
                });
                $(".rfile").click(function() {
                    var a = $(this).data("rfile");
                    fba_file(a);
                    window.history.pushState(null, null, "?path=" + a);
                    return false
                })
            }
        })
    }

    function fba_file(c) {
			$("#rf").html('');
			h.setValue('');
			//enable btn
			enable_save_del();
			$.ajax({
            type: "POST",
            url: g.host + g.api,
            data: 'file=' + c,
            crossDomain: false,
            dataType: "json"
        }).done(function(a) {
            if (a.status == 'success') {
                $("#rf").html(c);
                h.setValue(a.text)
            }
        })
    }
		
		function enable_save_del(){
			$('#btn-save-fba').removeAttr('disabled');
			$('#btn-del-fba').removeAttr('disabled');
		};
		
		function disable_save_del(){
			$('#btn-save-fba').attr("disabled", "disabled");
			$('#btn-del-fba').attr("disabled", "disabled");
		};
		
    function fba_size(e) {
        var t = ["Bytes", "KB", "MB", "GB", "TB"];
        if (e == 0) return "0 Bytes";
        var n = parseInt(Math.floor(Math.log(e) / Math.log(1024)));
        return Math.round(e / Math.pow(1024, n), 2) + " " + t[n]
    }


}
