/**
 * main.js
 * 
 * The script file that takes care of the user-interactions.
 */

/**
 * Configuration. Change anything here.
 */

/**
 * The search's base url
 */
var BASE_URL = 'http://localhost/~ajay/pages/fun/flickr/go/';

/**
 * Limit how many pages are shown in the pagination tool
 */
var pagelimit = 10;

/**
 * Shouldn't need to change any configuration past here.
 */


/**
 * Search for query and start with a specific page.
 * 
 * $page integer Page number. Defaults to 1 if none provided
 */
function search(page) {
	if(page === undefined) {
		page = 1;
	}

	var url = BASE_URL + $('#q').val() + '/' + page;
	doSearch(url);
}

/**
 * Perform the search based on the url passed. The url should 
 * be pointing to the local instance. The returned data is iterated 
 * thru' and displayed appropriately. 
 * 
 * $url string URL for the search query
 */
function doSearch(url) {
	$.getJSON(url, function(data) {
		var photos = data.photos;
		var photolist = [];

		$.each(photos.photo, function(idx, photo) {

			var purl = 'http://farm' + photo.farm + '.staticflickr.com/' + photo.server + '/' + photo.id + '_' + photo.secret + '_m.jpg';

			var phtml = '<a href="' + BASE_URL + '../view/' + photo.id + '" title="' + photo.title + '">';
			phtml += '<img src="' + purl + '" alt="' + photo.title + '" />';
			phtml += '</a>';

			photolist.push(phtml);
		});

		$('#photos').html(photolist.join(''));
		$('#pcount').html(photos.total);

		generatePageIndex(photos.total, photos.pages, photos.page);
	});
}

/**
 * Generates pagination for the resulting images
 * 
 * $total integer Total number of images returned
 * $pages integer Total number of pages returned
 * $current integer Current page
 *
 */
function generatePageIndex(total, pages, current) {

	var html = "";

	// generate the FIRST and PREVIOUS links
	if(current > 1) {
		html += '<li><a class="page small green" href="' + BASE_URL + $('#q').val() + '/1">First</a></li>';
		html += '<li><a class="page small green" href="' + BASE_URL + $('#q').val() + '/' + (current - 1) + '">Previous</a></li>';
	} else {
		html += '<li class="disabled">First</li>';
		html += '<li class="disabled">Previous</li>';
	}

	// control how many previous page links you see when on the last page
	var i = 1;
	if(current > pagelimit) {
		if(current + pagelimit > pages) {
			i = current - (pagelimit / 2);
		} else {
			i = current;
		}
	}

	// the page index
	var p = 0;
	for(; i < pages + 1; i++) {
		html += '<li>';
		if(current == i) {
			html += '<a class="page small green active" href="' + BASE_URL + $('#q').val() + '/' + i + '">' + i + '</a>';
		} else {
			html += '<a class="page small green" href="' + BASE_URL + $('#q').val() + '/' + i + '">' + i + '</a>';
		}
		html += '</li>';

		if(pagelimit == ++p)
			break;
	}

	// anymore pages left?
	if(i < pages) {
		html += '<li><a class="page small green" href="' + BASE_URL + $('#q').val() + '/' + (i + 1) + '">' + (pages - i) + ' more...</a></li>';
	}

	// generate the NEXT  and LAST links
	if(current < pages) {
		html += '<li><a class="page small green" href="' + BASE_URL + $('#q').val() + '/' + (current + 1) + '">Next</a></li>';
		html += '<li><a class="page small green" href="' + BASE_URL + $('#q').val() + '/' + pages + '">Last</a></li>';
	} else {
		html += '<li class="disabled">Next</li>';
		html += '<li class="disabled">Last</li>';
	}

	$('#paginate').html(html);

}


/**
 * Start everything when the page loads.
 */
$(document).ready(function() {

	// catch the search button click
	// and call the ajax search
	$("#btnsearch").click(function() {
		search(1);
		return false;
	});
	
	// catch the form submit and
	// and call the ajax search instead
	$('#frmSearch').submit(function() {
		search(1);
		return false;
	});
	
	// catch the paginated link clicks
	// and call the ajax search
	$('#paginate li a.page').live("click", function(event) {
		var ae = $($(this)[0]);
		if(!ae.hasClass('active')) {
			doSearch(ae.attr('href'));
		}
		return false;
	});
	
	// run the default search when the page loads
	search(1);
});
