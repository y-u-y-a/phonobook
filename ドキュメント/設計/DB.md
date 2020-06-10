# データベース設計
​
## users table
| カラム名 | データ型 | オプション |
|-------|----------|-----------|
| name | string | null: false, unique, add_index |
| password | ~ |  |
| remember_token | ~ |  |
| created_at | timestamp |  |
| updated_at | timestamp |  |
| book_id | string | FK |
### Association
- has_many: books
