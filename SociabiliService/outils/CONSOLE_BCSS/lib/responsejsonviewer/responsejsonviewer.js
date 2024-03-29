 
!function($){
	
	$.fn.getResponsejson = function(responsejson, heading) {
		$("#headingflux").remove();
		$("#responsejson").html("");
		var counter = 1 
		$(document).on('keypress',function(e) {
		    if(e.which == 45) {	
		    	viewer(responsejson.ARG_SOAP, counter);
		    	 counter++;
		    } 
		    if(e.which == 43) {
		    	viewer(responsejson, counter);
		    	counter++;
			} 
		});
		$("#responseshow").prepend('<div id="headingflux">'+heading+'</div>'); 
	};

	function viewer(responsejson, counter) {	
		if(counter % 2 == 0) {		    
		    $("#responseshow").hide();
		} else {
			$("#responsejson").responsejsonViewer(responsejson);
			$("#responseshow").show().draggable({ handle: '#headingflux', opacity: 0.9});
		}	
	}
	
	$.fn.responsejsonViewer = function(responsejson) {
		return this.each( function() {
			var self = $(this);
			if(typeof responsejson == 'object') {
				self.data('responsejson', JSON.stringify(responsejson))
			} else {
				self.data('responsejson', '');
			}
			new responsejsonViewer(self);
		});
	};
	
	function responsejsonViewer(self) {
		self.html('<ul class="responsejson-container"></ul>');
		try {
			var json = $.parseJSON(self.data('responsejson'));
			self.find('.responsejson-container').append(json2html([json]));
		} catch(e) {
			self.prepend('<div class="responsejson-error" >' + e.toString() + ' </div>');
			self.find('.responsejson-container').append(self.data('responsejson'));
		}
	}
	
	function json2html(json) {
		var html = '';
		for(var key in json) {
			if (!json.hasOwnProperty(key)) {
				continue;
			}
			var value = json[key],
				type = typeof json[key];
			html = html + createElement(key, value, type);
		}
		return html;
	}

	function encode(value) {
		return $('<div/>').text(value).html();
	}

	function createElement(key, value, type) {
		var klass = 'object',
        	jopen = '{',
        	jclose = '}';
		if(value === null) {
			var html = '<li>';
				html += '<span class="key">"' + encode(key) + '": </span>';
				html += '<span class="null">"' + encode(value) + '"</span>';
				html += '</li>';
			return html; 
		}
		if(type == 'object') {
			var html = '<li>';
				html += '<span class="expanded"></span>';
				html += '<span class="key">"' + encode(key) + '": </span>';
				html += '<span class="jopen">' + jopen + '</span>';
				html += '<ul class="' + klass + '">';
			var object = html + json2html(value);
			return object + '</ul><span class="jclose">' + jclose + '</span></li>';
		}
		if(type == 'number' || type == 'boolean') {
			var html = '<li>';
				html += '<span class="key">"' + encode(key) + '": </span>';
				html += '<span class="'+ type + '">' + encode(value) + '</span>';
				html += '</li>';
			return html;
		}
		var html = '<li>';
			html += '<span class="key">"' + encode(key) + '": </span>';
			html += '<span class="'+ type + '">"' + encode(value) + '"</span>';
			html += '</li>';
		return html;
	}

	$(document).on('click', '.responsejson-container .expanded', function(event) {
		event.preventDefault();
		event.stopPropagation();
		var $self = $(this);
		$self.parent().find('>ul').slideUp(100, function() {
			$self.addClass('collapsed');
		});
	});

	$(document).on('click', '.responsejson-container .expanded.collapsed', function(event) {
		event.preventDefault();
		event.stopPropagation();
		var $self = $(this);
		$self.removeClass('collapsed').parent().find('>ul').slideDown(100, function() {
			$self.removeClass('collapsed').removeClass('hidden');
		});
	});

}(window.jQuery);
