jQuery(document).ready(function($) {
    // La schimbarea valorii în select
    $('#preset-select').on('change', function() {
        var selectedPreset = $(this).val();
        var presetContent = '';

        if (selectedPreset === 'preset1') {
			var imageSource = 'https://raw.githubusercontent.com/Dascent/plugins/main/assets/images/vcs-upload.png';
    var presetContent = '<div style="display:block;width:100%;height:auto;margin:10px auto 12px auto;padding:2em 1em 2em;border:1px solid #555;text-align:center;box-sizing:border-box;background-color:#f1f1f1;border-radius:6px;"><div style="display:block;max-width:70%;min-width:300px;height:auto;margin:30px auto 33px auto;text-align:center;box-sizing:border-box;padding:2em;background-color:#fff;color:#036;"><img src="' + imageSource + '" width="100" height="100" alt="Image" style="margin:0 auto 6px auto;"/><h4 style="color:#cf0c84;">Access Upload</h4><p>You need to Login or be a Registered member of this platform to access this section.</p></div></div>';
        } else if (selectedPreset === 'preset2') {
            var imageSource = 'https://raw.githubusercontent.com/Dascent/plugins/main/assets/images/vcs-download.png';
    var presetContent = '<div style="display:block;width:100%;height:auto;margin:10px auto 12px auto;padding:2em 1em 2em;border:1px solid #555;text-align:center;box-sizing:border-box;background-color:#f1f1f1;border-radius:6px;"><div style="display:block;max-width:70%;min-width:300px;height:auto;margin:30px auto 33px auto;text-align:center;box-sizing:border-box;padding:2em;background-color:#fff;color:#036;"><img src="' + imageSource + '" width="100" height="100" alt="Image" style="margin:0 auto 6px auto;"/><h4 style="color:#bb5bd9;">Download File</h4><p>You need to Login or be a Registered member of this platform to access this content.</p></div></div>';
        } else if (selectedPreset === 'preset3') {
           var imageSource = 'https://raw.githubusercontent.com/Dascent/plugins/main/assets/images/vcs-unlock.png';
    var presetContent = '<div style="display:block;width:100%;height:auto;margin:10px auto 12px auto;padding:2em 1em 2em;border:1px solid #555;text-align:center;box-sizing:border-box;background-color:#f1f1f1;border-radius:6px;"><div style="display:block;max-width:70%;min-width:300px;height:auto;margin:30px auto 33px auto;text-align:center;box-sizing:border-box;padding:2em;background-color:#fff;color:#036;"><img src="' + imageSource + '" width="100" height="100" alt="Image" style="margin:0 auto 6px auto;"/><h4 style="color:#5b93d4;">Access Content</h4><p>You need to Login or be a Registered member of this platform to access this content</p></div></div>';
        } else if (selectedPreset === 'preset4') {
    var imageSource = 'https://raw.githubusercontent.com/Dascent/plugins/main/assets/images/vcs-play.png';
    var presetContent = '<div style="display:block;width:100%;height:auto;margin:10px auto 12px auto;padding:2em 1em 2em;border:1px solid #555;text-align:center;box-sizing:border-box;background-color:#f1f1f1;border-radius:6px;"><div style="display:block;max-width:70%;min-width:300px;height:auto;margin:30px auto 33px auto;text-align:center;box-sizing:border-box;padding:2em;background-color:#fff;color:#036;"><img src="' + imageSource + '" width="100" height="100" alt="Image" style="margin:0 auto 6px auto;"/><h4 style="color:#c2200e;">Play or Download Media File</h4><p>You need to Login or be a Registered member of this platform to access this content.</p></div></div>';


        } else if (selectedPreset === 'preset5') {
            var imageSource = 'https://raw.githubusercontent.com/Dascent/plugins/main/assets/images/vcs-see.png';
    var presetContent = '<div style="display:block;width:100%;height:auto;margin:10px auto 12px auto;padding:2em 1em 2em;border:1px solid #555;text-align:center;box-sizing:border-box;background-color:#f1f1f1;border-radius:6px;"><div style="display:block;max-width:70%;min-width:300px;height:auto;margin:30px auto 33px auto;text-align:center;box-sizing:border-box;padding:2em;background-color:#fff;color:#036;"><img src="' + imageSource + '" width="100" height="100" alt="Image" style="margin:0 auto 6px auto;"/><h4 style="color:#f58522;">View Content</h4><p>You need to Login or be a Registered member of this platform to access this content.</p></div></div>';
        }
		
		else if (selectedPreset === 'preset6') {
            var imageSource = 'https://raw.githubusercontent.com/Dascent/plugins/main/assets/images/vcs-photo.png';
    var presetContent = '<div style="display:block;width:100%;height:auto;margin:10px auto 12px auto;padding:2em 1em 2em;border:1px solid #555;text-align:center;box-sizing:border-box;background-color:#f1f1f1;border-radius:6px;"><div style="display:block;max-width:70%;min-width:300px;height:auto;margin:30px auto 33px auto;text-align:center;box-sizing:border-box;padding:2em;background-color:#fff;color:#036;"><img src="' + imageSource + '" width="100" height="100" alt="Image" style="margin:0 auto 6px auto;"/><h4 style="color:#f522c0;">View Image</h4><p>You need to Login or be a Registered member of this platform to access this content.</p></div></div>';
        }

     

        // Setează conținutul în editor
        $('#custom_content_non_registered_ifr').contents().find('body').html(presetContent);
    });
});





