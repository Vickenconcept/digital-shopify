import re
from pathlib import Path

src = Path(r"C:\Users\i7Dell\Downloads\kHub.sql")
destinations = [
    Path(r"C:\Users\i7Dell\Downloads\kHub-import-ready.sql"),
    Path(__file__).resolve().parent / "kHub-import-ready.sql",
]

content = src.read_text(encoding="utf-8")

# Remove conditional mysql dump headers/footers
content = re.sub(
    r"/\*!40101 SET @OLD_CHARACTER_SET_CLIENT.*?\*/;\s*",
    "",
    content,
    flags=re.S,
)
content = re.sub(
    r"/\*!40103 SET TIME_ZONE=IFNULL.*?/\*!40111 SET SQL_NOTES=IFNULL\(@OLD_SQL_NOTES, 1\) \*/;\s*",
    "",
    content,
    flags=re.S,
)
content = re.sub(
    r"/\*!40101 SET NAMES utf8 \*/;\s*",
    "",
    content,
)
content = re.sub(
    r"/\*!50503 SET NAMES utf8mb4 \*/;\s*",
    "",
    content,
)
content = re.sub(
    r"/\*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE \*/;\s*",
    "",
    content,
)
content = re.sub(
    r"/\*!40103 SET TIME_ZONE='\+00:00' \*/;\s*",
    "",
    content,
)
content = re.sub(
    r"/\*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 \*/;\s*",
    "",
    content,
)
content = re.sub(
    r"/\*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' \*/;\s*",
    "",
    content,
)
content = re.sub(
    r"/\*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 \*/;\s*",
    "",
    content,
)

# Remove inline FOREIGN KEY constraints from CREATE TABLE statements
fk_pattern = re.compile(
    r",?\s*CONSTRAINT `[^`]+` FOREIGN KEY \([^)]+\) REFERENCES `[^`]+` \(`[^`]+`\) ON DELETE CASCADE",
    re.MULTILINE,
)
content = fk_pattern.sub("", content)

header = """-- Import-ready dump (foreign keys deferred)
-- Generated from kHub.sql

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET TIME_ZONE = '+00:00';

"""

footer = """
-- --------------------------------------------------------
-- Foreign key constraints (applied after all tables exist)
-- --------------------------------------------------------

ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `digital_products`
  ADD CONSTRAINT `digital_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `digital_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_digital_product_id_foreign` FOREIGN KEY (`digital_product_id`) REFERENCES `digital_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

SET FOREIGN_KEY_CHECKS = 1;
"""

out = header + content.strip() + footer

for dest in destinations:
    dest.write_text(out, encoding="utf-8")
    print(f"Created {dest}")

remaining = len(fk_pattern.findall(content))
inline_fks = len(re.findall(r"CONSTRAINT `[^`]+` FOREIGN KEY", content))
print(f"Inline FK constraints remaining in CREATE blocks: {inline_fks}")
