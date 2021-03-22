ALTER TABLE list_item DROP COLUMN url
CREATE TABLE list_item_link (id BIGSERIAL PRIMARY KEY, item_id BIGINT NOT NULL REFERENCES list_item (id) ON DELETE CASCADE, page_url TEXT NOT NULL, page_title VARCHAR(250) NOT NULL, image_url TEXT)