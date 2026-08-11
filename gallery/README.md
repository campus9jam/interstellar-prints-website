# Gallery Images Directory

Upload your product photos, design mockups, and completed work images here.

## Naming Convention

Use these filenames to match the gallery grid in index.php:

### Mockups
- `mockup-1.jpg` — Business card mockup
- `mockup-2.jpg` — T-shirt print mockup
- `mockup-3.jpg` — Branded mug mockup

### Designs
- `design-1.jpg` — Logo concept
- `design-2.jpg` — Event flyer
- `design-3.jpg` — Stationery suite

### Completed Works
- `work-1.jpg` — Corporate uniforms
- `work-2.jpg` — Corporate diaries
- `work-3.jpg` — Branded tote bags

## How to Add More Images

1. Upload your image to this `gallery/` folder via cPanel File Manager or FTP.
2. Open `index.php` and find the `<!-- Gallery Grid -->` section.
3. Copy one of the existing `<div class="gallery-item">` blocks.
4. Update the `src`, `alt`, `data-category`, title, and description.
5. Save and upload.

## Categories

- `mockups` — Design mockups and previews
- `designs` — Artwork and design files
- `works` — Photos of completed projects

## Image Tips

- Recommended size: 600x600px or larger (square works best)
- Use JPG format for photos, PNG for designs with transparency
- Keep file sizes under 500KB for fast loading
- Compress images using TinyPNG or similar tools
