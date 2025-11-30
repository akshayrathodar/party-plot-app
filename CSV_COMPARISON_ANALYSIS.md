# CSV to Database Field Comparison Analysis

## Summary
This document compares the cleaned CSV file fields with the `party_plots` database table structure.

---

## ✅ Fields Present in CSV (Mapped to DB)

| CSV Column | Database Field | Status | Notes |
|------------|----------------|--------|-------|
| Name | `name` | ✅ Direct Map | Required field |
| Full Address | `full_address` | ✅ Direct Map | Required field (cleaned) |
| City | `city` | ✅ Direct Map | Extracted from address |
| Phone | `phone` | ✅ Direct Map | Optional |
| Review Count | `google_review_count` | ✅ Direct Map | Optional |
| Average Rating | `google_rating` | ✅ Direct Map | Optional |
| Latitude | `latitude` | ✅ Direct Map | Required field |
| Longitude | `longitude` | ✅ Direct Map | Required field |
| Website | `website` | ✅ Direct Map | Optional |
| Featured Image | `featured_image` | ✅ Direct Map | Optional (URL) |
| Email | `email` | ✅ Direct Map | Optional |
| Instagram | `instagram` | ✅ Direct Map | Optional |
| Facebook | `facebook` | ✅ Direct Map | Optional |
| YouTube | `youtube` | ✅ Direct Map | Optional |
| Twitter | `twitter` | ✅ Direct Map | Optional |
| Description | `description` | ✅ Direct Map | Optional |
| Categories | `suitable_events` or `tags` | ⚠️ Needs Processing | Can be mapped to suitable_events or tags field |
| Street | - | ⚠️ Can be merged | Can be merged into full_address |

---

## ❌ Fields Missing in CSV (Present in DB)

### Required Fields (Need to be handled during import)
1. **`slug`** - Can be auto-generated from `name` during import
2. **`creator_user_id`** - System field, needs to be set during import (default admin user)

### Optional Venue Details (Not in CSV)
3. **`capacity_min`** - Minimum capacity
4. **`capacity_max`** - Maximum capacity
5. **`price_range_min`** - Starting price
6. **`price_range_max`** - Maximum price
7. **`area_lawn`** - Lawn area size
8. **`area_banquet`** - Banquet area size
9. **`suitable_events`** - Can be populated from Categories column

### Optional Amenities (Boolean fields - Not in CSV)
10. **`parking`** - Parking availability
11. **`rooms`** - Rooms available
12. **`dj_allowed`** - DJ allowed
13. **`decoration_allowed`** - Decoration allowed
14. **`catering_allowed`** - Catering allowed
15. **`generator_backup`** - Generator backup
16. **`ac_available`** - AC available

### Optional Media (Not in CSV)
17. **`gallery_images`** - Additional images (JSON array)
18. **`video_links`** - Video links (JSON array)

### Optional Ratings (Partially in CSV)
19. **`google_review_text`** - Review text/details (not in CSV)

### System Fields (Auto-managed)
20. **`status`** - Default: 'active'
21. **`listing_status`** - Default: 'pending'
22. **`verified`** - Default: false
23. **`claimed_by_user_id`** - Nullable
24. **`place_id`** - Removed from CSV as requested

---

## 🗑️ Fields Removed from CSV (As Requested)

1. **Place Id** - Removed (not useful for import)
2. **Cid** - Removed (not needed)
3. **Review URL** - Removed (not needed)
4. **Google Maps URL** - Removed (not needed)
5. **Domain** - Removed (redundant with Website)
6. **Opening Hours** - Removed (not in DB schema)
7. **Price** - Removed (not properly structured, use price_range_min/max instead)
8. **Phones** - Removed (duplicate of Phone)
9. **Claimed** - Removed (not in DB schema)

---

## 📝 Address Improvements Made

1. **Pincode Placement**: Moved pincode to end of address (standard Indian format)
2. **Plot Code Removal**: Removed leading plot codes like "7Q75", "8R8C", "360006" from start of address
3. **City Extraction**: Extracted city from address into separate column
4. **Formatting**: Cleaned up extra commas and spaces

### Example Improvements:
- **Before**: `"360006, Krishna Society, Madhapar, Rajkot, Gujarat 360006"`
- **After**: `"Krishna Society, Madhapar, Rajkot, Gujarat, 360006"`

- **Before**: `"7Q75 , Mota Mava, Rajkot, Gujarat 360005"`
- **After**: `"Mota Mava, Rajkot, Gujarat, 360005"`

---

## 🔄 Import Recommendations

### During CSV Import:
1. **Auto-generate `slug`** from `name` field
2. **Set `creator_user_id`** to default admin user (or system user)
3. **Map `Categories`** to `suitable_events` field (comma-separated or JSON)
4. **Set defaults** for missing optional fields:
   - `status` = 'active'
   - `listing_status` = 'pending'
   - `verified` = false
   - All boolean amenities = false
5. **Handle `Featured Image`**: The CSV contains URLs, you may want to download and store locally, or keep as URL

### Optional Enhancements:
- Parse `Description` to extract amenities (parking, AC, etc.) if mentioned
- Extract price information from `Description` if available
- Validate and format phone numbers consistently

---

## ✅ Conclusion

The cleaned CSV contains **most essential fields** needed for import. The missing fields are either:
- **System fields** that can be auto-set during import
- **Optional fields** that can remain null
- **Fields that can be derived** from existing data (like slug from name)

The CSV is ready for import with minimal additional processing needed.

