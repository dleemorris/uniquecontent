(function( $ ) {

	'use strict';
	$(document).ready(function() {

		var lduccCourseItem = '';
		lduccCourseItem += '<div class="learndash-ucc-courses-item">';
		lduccCourseItem += '<select name="RANDOMKEY">';
		$.each(lduucVariables.courses, function(key, value){
			if('select' == key){
				lduccCourseItem += '<option value="' + key + '" selected>' + value + '</option>';
			}else{
				lduccCourseItem += '<option value="' + key + '">' + value + '</option>';
			}
		});
		lduccCourseItem += '</select>';
		lduccCourseItem += '<span class="learndash-ucc-courses-delete"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="16px" height="16px" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4l-66.1.3c-4.4 0-8-3.5-8-8c0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 0 1-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4l66-.3c4.4 0 8 3.5 8 8c0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2c0 4.4-3.6 8-8 8z" fill="#626262"/></svg></span>';
		lduccCourseItem += '</div>';	
		
		var lduccGroupItem = '';
		lduccGroupItem += '<div class="learndash-ucc-groups-item">';
		lduccGroupItem += '<select name="RANDOMKEY">';
		$.each(lduucVariables.groups, function(key, value){
			if('select' == key){
				lduccGroupItem += '<option value="' + key + '" selected>' + value + '</option>';
			}else{
				lduccGroupItem += '<option value="' + key + '">' + value + '</option>';
			}
		});
		lduccGroupItem += '</select>';
		lduccGroupItem += '<span class="learndash-ucc-groups-delete"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="16px" height="16px" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4l-66.1.3c-4.4 0-8-3.5-8-8c0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 0 1-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4l66-.3c4.4 0 8 3.5 8 8c0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2c0 4.4-3.6 8-8 8z" fill="#626262"/></svg></span>';
		lduccGroupItem += '</div>';		

		var lduccUserItem = '';
		lduccUserItem += '<div class="learndash-ucc-users-item">';
		lduccUserItem += '<select name="RANDOMKEY">';
		$.each(lduucVariables.users, function(key, value){
			if('select' == key){
				lduccUserItem += '<option value="' + key + '" selected>' + value + '</option>';
			}else{
				lduccUserItem += '<option value="' + key + '">' + value + '</option>';
			}
		});
		lduccUserItem += '</select>';
		lduccUserItem += '<span class="learndash-ucc-users-delete"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="16px" height="16px" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4l-66.1.3c-4.4 0-8-3.5-8-8c0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 0 1-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4l66-.3c4.4 0 8 3.5 8 8c0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2c0 4.4-3.6 8-8 8z" fill="#626262"/></svg></span>';
		lduccUserItem += '</div>';			

		/*
		$('.ld-ucc-meta-overlay').animate(
			{
				'opacity':0,
			},
			1000,
			function(){
				$(this).css({'display':'none'});
			}
		);
		*/

		$('.ld-ucc-course-add span').on('click', function(){

			var ldrcRandom = Math.random().toString(36).slice(2);
			var lduccCourseItemNew = '';
			lduccCourseItemNew = lduccCourseItem;
			lduccCourseItemNew = lduccCourseItemNew.replace("RANDOMKEY", ldrcRandom);
			$('.ld-ucc-course-add-before').before(lduccCourseItemNew);

			var lduccCurrent = $('.ld-ucc-courses').val();
			lduccCurrent = lduccCurrent + ':' + ldrcRandom;
			$('.ld-ucc-courses').val(lduccCurrent);

		});
		
		$('.ld-ucc-course-container').on('click', '.learndash-ucc-courses-delete', function(){

			var ldrcDelete = $('.ld-ucc-courses-delete').val();
			var ldrcId = $(this).siblings('select').attr('name');
			$('.ld-ucc-courses-delete').val(ldrcDelete + ':' + ldrcId);
			$(this).closest('.learndash-ucc-courses-item').remove();

		});		
		
		$('.ld-ucc-group-add span').on('click', function(){

			var ldrcRandom = Math.random().toString(36).slice(2);
			var lduccGroupItemNew = '';
			lduccGroupItemNew = lduccGroupItem;
			lduccGroupItemNew = lduccGroupItemNew.replace("RANDOMKEY", ldrcRandom);
			$('.ld-ucc-group-add-before').before(lduccGroupItemNew);
		
			var lduccCurrent = $('.ld-ucc-groups').val();
			lduccCurrent = lduccCurrent + ':' + ldrcRandom;
			$('.ld-ucc-groups').val(lduccCurrent);
		
		});
		
		$('.ld-ucc-group-container').on('click', '.learndash-ucc-groups-delete', function(){
		
			var ldrcDelete = $('.ld-ucc-groups-delete').val();
			var ldrcId = $(this).siblings('select').attr('name');
			$('.ld-ucc-groups-delete').val(ldrcDelete + ':' + ldrcId);
			$(this).closest('.learndash-ucc-groups-item').remove();
		
		});	
		
		$('.ld-ucc-user-add span').on('click', function(){

			var ldrcRandom = Math.random().toString(36).slice(2);
			var lduccUserItemNew = '';
			lduccUserItemNew = lduccUserItem;
			lduccUserItemNew = lduccUserItemNew.replace("RANDOMKEY", ldrcRandom);
			$('.ld-ucc-user-add-before').before(lduccUserItemNew);
		
			var lduccCurrent = $('.ld-ucc-users').val();
			lduccCurrent = lduccCurrent + ':' + ldrcRandom;
			$('.ld-ucc-users').val(lduccCurrent);
		
		});
		
		$('.ld-ucc-user-container').on('click', '.learndash-ucc-users-delete', function(){
		
			var ldrcDelete = $('.ld-ucc-users-delete').val();
			var ldrcId = $(this).siblings('select').attr('name');
			$('.ld-ucc-users-delete').val(ldrcDelete + ':' + ldrcId);
			$(this).closest('.learndash-ucc-users-item').remove();
		
		});	
		
		$('.ld-ucc-users').select2({width:'100%'});
		$('.ld-ucc-groups').select2({width:'100%'});
		$('.ld-ucc-courses').select2({width:'100%'});

	});

})( jQuery );
