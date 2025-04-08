# Modern File Upload Field for Elementor Forms

A customizable, modern file upload component for Elementor forms with drag-and-drop functionality that displays selected filenames.

![Preview of the custom file upload field](https://placeholder-image.jpg)

## Features

- ✅ Modern, clean UI with drag-and-drop support
- ✅ Shows selected filenames to users
- ✅ Displays helpful file type and size information
- ✅ Works with any Elementor form
- ✅ Customizable design to match your site's theme
- ✅ Mobile-friendly responsive design

## Implementation Guide

### Step 1: Add the HTML Widget to Your Form

1. Edit your Elementor form in Elementor editor
2. Add an HTML widget to your form (above where you want the file upload field)
3. In the Advanced tab, give this HTML widget a custom ID (e.g., `form-custom-upload`)
4. Add a File Upload field below the HTML widget in your form

### Step 2: Copy the Following Code into the HTML Widget

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom File Upload</title>
    <style>
        /* Custom upload area styling */
        .custom-upload-area {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            background-color: #ffffff;
            margin-bottom: 10px;
        }
        
        .custom-upload-area:hover {
            border-color: #ccc;
        }
        
        .upload-icon {
            color: #aaa;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .upload-text {
            color: var(--e-global-color-text, #333);
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .upload-subtext {
            color: #999;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        
        /* File list styling */
        .selected-files {
            text-align: left;
            margin-top: 10px;
            max-height: 100px;
            overflow-y: auto;
            padding: 0 10px;
        }
        
        .file-item {
            font-size: 12px;
            color: #666;
            margin: 4px 0;
        }
        
        /* File information text styling */
        .file-info-text {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #666;
            line-height: 1.4;
            margin-top: 15px;
        }
        
        .file-info-text strong {
            font-weight: bold;
            color: var(--e-global-color-text, #333);
        }
        
        /* Hide the original file input */
        .elementor-field-type-upload input[type="file"] {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Add this code to your Elementor Custom HTML widget -->
    <div class="custom-upload-area" id="custom-upload-trigger">
        <div class="upload-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 16V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21H7C6.46957 21 5.96086 20.7893 5.58579 20.4142C5.21071 20.0391 5 19.5304 5 19V16" stroke="#AAAAAA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 3V16M12 3L7 8M12 3L17 8" stroke="#AAAAAA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="upload-text">Click or drag files to this area to upload.</div>
        <div class="upload-subtext">You can upload up to 25 files.</div>
        <div class="selected-files" id="selected-files-list"></div>
    </div>

    <!-- File information text -->
    <div class="file-info-text">
        <p><strong>Accepted file types:</strong> .xlxs, .jpg, .jpeg, .doc, .docx, .pdf, .png</p>
        <p><strong>Max Upload:</strong> 25mb.</p>
        <p><strong>Please Note:</strong> If you encounter upload issues, please remove all selected files and try uploading again. To modify your selection, simply choose all desired files again.</p>
    </div>

    <script>
    // Add this script to your page
    document.addEventListener('DOMContentLoaded', function() {
        // Get the closest form or section
        const htmlWidget = document.getElementById('custom-upload-trigger').closest('.elementor-widget-html');
        const parentForm = htmlWidget ? htmlWidget.closest('form') : null;
        
        const customUploadArea = document.getElementById('custom-upload-trigger');
        let fileInput;
        
        // Find the file input in the parent form
        if (parentForm) {
            fileInput = parentForm.querySelector('.elementor-field-type-upload input[type="file"]');
        } else {
            // Fallback - look for file input after this HTML widget
            const nextElement = htmlWidget ? htmlWidget.nextElementSibling : null;
            if (nextElement && nextElement.querySelector('input[type="file"]')) {
                fileInput = nextElement.querySelector('input[type="file"]');
            } else {
                // Final fallback - any file input on the page
                fileInput = document.querySelector('.elementor-field-type-upload input[type="file"]');
            }
        }
        
        const selectedFilesList = document.getElementById('selected-files-list');
        
        if (customUploadArea && fileInput) {
            // Trigger file input when custom area is clicked
            customUploadArea.addEventListener('click', function() {
                fileInput.click();
            });
            
            // Update text and show file names when files are selected
            fileInput.addEventListener('change', function() {
                const fileCount = this.files.length;
                
                // Update main text
                if (fileCount > 0) {
                    document.querySelector('.upload-text').textContent = fileCount === 1 
                        ? '1 file selected' 
                        : `${fileCount} files selected`;
                    
                    // Display file names
                    selectedFilesList.innerHTML = '';
                    for (let i = 0; i < this.files.length; i++) {
                        const fileItem = document.createElement('div');
                        fileItem.className = 'file-item';
                        fileItem.textContent = this.files[i].name;
                        selectedFilesList.appendChild(fileItem);
                    }
                } else {
                    document.querySelector('.upload-text').textContent = 'Click or drag files to this area to upload.';
                    selectedFilesList.innerHTML = '';
                }
            });
            
            // Handle drag and drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                customUploadArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                customUploadArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                customUploadArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                customUploadArea.style.borderColor = '#666';
                customUploadArea.style.backgroundColor = '#f7f7f7';
            }
            
            function unhighlight() {
                customUploadArea.style.borderColor = '#e0e0e0';
                customUploadArea.style.backgroundColor = '#ffffff';
            }
            
            customUploadArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                
                // Trigger change event
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }
        }
    });
    </script>
</body>
</html>
```

### Step 3: Targeting a Specific Form (Optional)

If you have multiple forms on your page and want to target only a specific form, follow these additional steps:

1. Give your target form a specific ID in Elementor (e.g., "my-upload-form")
2. Add these CSS scoping rules to the beginning of each CSS selector in the code:
   ```css
   /* Example of scoped CSS */
   #my-upload-form .custom-upload-area { ... }
   #my-upload-form .upload-icon { ... }
   ```

3. Update the JavaScript to specifically target elements within your form:
   ```javascript
   const formElement = document.getElementById('my-upload-form');
   if (!formElement) return; // Exit if form doesn't exist
   
   const fileInput = formElement.querySelector('.elementor-field-type-upload input[type="file"]');
   ```

### Step 4: Customization Options

#### Change Accepted File Types

Edit the file types listed in the `.file-info-text` div:

```html
<p><strong>Accepted file types:</strong> .xlxs, .jpg, .jpeg, .doc, .docx, .pdf, .png</p>
```

#### Change Maximum Upload Size

Edit the maximum upload size in the `.file-info-text` div:

```html
<p><strong>Max Upload:</strong> 25mb.</p>
```

#### Change Colors and Appearance

Modify the CSS variables or directly edit the colors in the style section:

```css
.custom-upload-area {
    border: 1px solid #YOUR_COLOR;
    /* other styling */
}
```

## Troubleshooting

### Upload Button Still Visible

If the original upload button is still visible, add this CSS to your page:

```css
.elementor-field-type-upload .elementor-field-textual {
    opacity: 0;
    height: 0;
    padding: 0;
    margin: 0;
    border: none;
}
```

### File Upload Not Working

If clicking the custom area doesn't trigger the file upload dialog:

1. Check that the HTML widget is placed directly above the file upload field.
2. Make sure the file input is properly targeted in the JavaScript.
3. Try adding a more specific selector to find the file input.

### Drag and Drop Not Working

If drag and drop functionality isn't working:

1. Ensure your browser supports the HTML5 File API.
2. Check browser console for any JavaScript errors.
3. Make sure the event handlers are properly attached.

## Credits

Developed by [Your Name/Organization]
