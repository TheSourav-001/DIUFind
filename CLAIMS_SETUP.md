# Claims System - Database Setup Guide

## Option 1: Run Migration Script (Recommended)

### Via XAMPP Shell:
1. Open **XAMPP Control Panel**
2. Click **Shell** button
3. Navigate to project:
   ```bash
   cd /xampp/htdocs/DIUfind
   ```
4. Run migration:
   ```bash
   php create_claims_table.php
   ```

### Via Browser:
1. Start XAMPP (Apache + MySQL)
2. Open browser and go to:
   ```
   http://localhost/DIUfind/create_claims_table.php
   ```
3. You should see: "✓ Claims table created successfully"

---

## Option 2: Manual SQL (If script doesn't work)

1. Open **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Select your database (e.g., `diufind`)
3. Click **SQL** tab
4. Paste and run this query:

```sql
CREATE TABLE IF NOT EXISTS `claims` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `post_id` INT(11) NOT NULL,
  `claimer_id` INT(11) NOT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`claimer_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

5. Click **Go**
6. Verify table created in left sidebar

---

## Verification

To verify the table was created correctly:

```sql
DESCRIBE claims;
```

Expected output:
```
+-----------+---------------------------------------------+------+-----+-------------------+
| Field     | Type                                        | Null | Key | Default           |
+-----------+---------------------------------------------+------+-----+-------------------+
| id        | int(11)                                     | NO   | PRI | NULL              |
| post_id   | int(11)                                     | NO   | MUL | NULL              |
| claimer_id| int(11)                                     | NO   | MUL | NULL              |
| message   | text                                        | NO   |     | NULL              |
| status    | enum('pending','accepted','rejected')       | YES  |     | pending           |
| created_at| datetime                                    | YES  |     | CURRENT_TIMESTAMP |
+-----------+---------------------------------------------+------+-----+-------------------+
```

---

## Testing the Features

### 1. Test Contact Buttons:
- Create a "Found" post with phone number in profile
- View post as different user
- Check WhatsApp and Call buttons appear

### 2. Test Claim Submission:
- As non-owner, click "Claim Item" on Found post
- Fill out claim form
- Submit claim

### 3. Test Claims Management:
- Login as post owner
- Go to Profile
- See "Claims Received" section
- Click Approve/Reject

---

## Troubleshooting

**Issue:** Foreign key error  
**Solution:** Make sure `posts` and `users` tables exist with `id` columns

**Issue:** Table already exists  
**Solution:** Migration is safe to run multiple times

**Issue:** PHP path not found  
**Solution:** Use browser method or phpMyAdmin SQL query

---

## Next Steps

After migration:
1. ✅ Update phone number in user settings
2. ✅ Create "Found" post to test
3. ✅ Test claim submission flow
4. ✅ Test claim approval/rejection
