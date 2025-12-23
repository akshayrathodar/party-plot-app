# Party Plots Table - Column Recommendations for CSV Import

## 📊 CSV to Database Column Mapping

### ✅ CSV Columns That Map Directly to Existing Database Fields

| CSV Column | Database Field | Type | Status | Notes |
|------------|----------------|------|--------|-------|
| **Name** | `name` | string | ✅ Exists | Required field |
| **Full Address** | `full_address` | text | ✅ Exists | Required field |
| **City** | `city` | string | ✅ Exists | Required field |
| **Phone** | `phone` | string | ✅ Exists | Optional |
| **Review Count** | `google_review_count` | integer | ✅ Exists | Optional |
| **Average Rating** | `google_rating` | decimal(3,2) | ✅ Exists | Optional |
| **Latitude** | `latitude` | decimal(10,8) | ✅ Exists | Required field |
| **Longitude** | `longitude` | decimal(11,8) | ✅ Exists | Required field |
| **Website** | `website` | string | ✅ Exists | Optional |
| **Featured Image** | `featured_image` | string | ✅ Exists | Optional (URL) |
| **Email** | `email` | string | ✅ Exists | Optional |
| **Instagram** | `instagram` | string | ✅ Exists | Optional |
| **Facebook** | `facebook` | string | ✅ Exists | Optional |
| **YouTube** | `youtube` | string | ✅ Exists | Optional |
| **Twitter** | `twitter` | string | ✅ Exists | Optional |
| **Description** | `description` | text | ✅ Exists | Optional (added via migration) |
| **Categories** | `suitable_events` | text | ✅ Exists | Optional (comma-separated or JSON) |

### ⚠️ CSV Columns That Need Special Handling

| CSV Column | Database Field | Action Required |
|------------|----------------|-----------------|
| **Street** | - | ⚠️ **Can be ignored** - Already part of `full_address` |

---

## 🔍 Database Fields NOT in CSV (No Action Needed)

These fields exist in the database but are not in the CSV. They will remain NULL or use default values:

### System Fields (Auto-set during import)
- `id` - Auto-increment
- `slug` - **Auto-generate from `name`** during import
- `creator_user_id` - **Set to default admin user** during import
- `status` - Default: 'active'
- `listing_status` - Default: 'pending'
- `verified` - Default: false
- `claimed_by_user_id` - NULL
- `place_id` - NULL (removed from CSV as requested)
- `created_at` / `updated_at` - Auto-set

### Optional Fields (Can remain NULL)
- `capacity_min` / `capacity_max` - Capacity information
- `price_range_min` / `price_range_max` - Pricing information
- `area_lawn` / `area_banquet` - Area measurements
- `parking` / `rooms` / `dj_allowed` / `decoration_allowed` / `catering_allowed` / `generator_backup` / `ac_available` - Amenities (boolean, default: false)
- `gallery_images` - Additional images (JSON array)
- `video_links` - Video links (JSON array)
- `google_review_text` - Review text/details
- `tags` - Tags (JSON array)

---

## ✅ RECOMMENDATION: No Column Changes Needed!

### Current Status
✅ **All CSV columns map to existing database fields**
✅ **No new columns need to be added**
✅ **No columns need to be removed**

### The table structure is already compatible with the CSV data!

---

## 📝 Import Mapping Instructions

### Direct Mappings (CSV → Database)
```php
'name' => $csv['Name'],
'full_address' => $csv['Full Address'],
'city' => $csv['City'],
'phone' => $csv['Phone'],
'google_review_count' => (int)$csv['Review Count'],
'google_rating' => (float)$csv['Average Rating'],
'latitude' => (float)$csv['Latitude'],
'longitude' => (float)$csv['Longitude'],
'website' => $csv['Website'],
'featured_image' => $csv['Featured Image'], // URL
'email' => $csv['Email'],
'instagram' => $csv['Instagram'],
'facebook' => $csv['Facebook'],
'youtube' => $csv['YouTube'],
'twitter' => $csv['Twitter'],
'description' => $csv['Description'],
'suitable_events' => $csv['Categories'], // Store as comma-separated or JSON
```

### Auto-Generated Fields
```php
'slug' => Str::slug($csv['Name']), // Auto-generate, ensure uniqueness
'creator_user_id' => Auth::id() ?? 1, // Set to current admin or default user
'status' => 'active',
'listing_status' => 'pending',
'verified' => false,
```

### Ignored CSV Column
- `Street` - Can be ignored (already part of `full_address`)

---

## 🎯 Summary

### ✅ What You Have
- **18 CSV columns** ready for import
- **All columns map to existing database fields**
- **No schema changes required**

### ✅ What to Do During Import
1. Map CSV columns to database fields (see mapping above)
2. Auto-generate `slug` from `name`
3. Set `creator_user_id` to admin user
4. Set default values for system fields
5. Convert `Categories` to `suitable_events` (comma-separated or JSON)
6. Ignore `Street` column (or merge into `full_address` if needed)

### ✅ Ready to Import
Your database table structure is **100% compatible** with the cleaned CSV file. No migrations needed!

---

## 📋 Quick Checklist for Import

- [x] All CSV columns have corresponding database fields
- [x] No new columns need to be added
- [x] No columns need to be removed
- [x] Import mapping is straightforward
- [x] System fields can be auto-set
- [x] Optional fields can remain NULL

**Status: ✅ READY FOR IMPORT**









