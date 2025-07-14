# Makefile untuk Mengelola Lingkungan Docker Laravel
#
# Prasyarat:
#   - Docker & Docker Compose
#   - jq (untuk mengambil URL Ngrok). Install: 'sudo apt-get install jq'
#   - sed (biasanya sudah terinstall di Linux/macOS/Git Bash)

# Mencegah konflik dengan file/folder bernama sama
.PHONY: run stop restart build reset logs shell shell-root artisan composer npm

# Perintah default (jika hanya mengetik 'make')
default: help

# Variabel untuk perintah kustom, dengan nilai default
cmd :=
s := app

# ==============================================================================
# MANAJEMEN KONTENER
# ==============================================================================

## run: Menjalankan semua kontainer, mengupdate .env, dan menampilkan URL publik Ngrok.
run:
	@echo "🚀 Menjalankan semua layanan Docker..."
	@docker compose up -d
	@echo "⏳ Menunggu Ngrok untuk menyediakan URL publik..."
	@NGROK_URL=""; \
	while [ -z "$$NGROK_URL" ]; do \
	  sleep 2; \
	  NGROK_URL=$$(curl -s http://localhost:4040/api/tunnels | jq -r '.tunnels[] | select(.proto=="https") | .public_url'); \
	  if [ "$$?" -ne 0 ]; then \
	  	NGROK_URL=""; \
	  fi; \
	done; \
	echo "✅ URL Publik Ngrok ditemukan: $$NGROK_URL"; \
	echo "📝 Memperbarui APP_URL di file .env..."; \
	sed -i.bak "s|^APP_URL=.*|APP_URL=$$NGROK_URL|" .env; \
	echo "🔄 Merestart kontainer aplikasi untuk menerapkan perubahan..."; \
	docker compose restart app; \
	echo ""; \
	echo "================================================="; \
	echo "✅ Aplikasi Anda dapat diakses di:"; \
	echo "   \033[36m$$NGROK_URL\033[0m"; \
	echo "   Dashboard Ngrok: http://localhost:4040"; \
	echo "================================================="; \
	echo ""

## stop: Menghentikan semua kontainer.
stop:
	@echo "🛑 Menghentikan semua layanan Docker..."
	@docker compose down

## restart: Merestart semua kontainer.
restart: stop run

## build: Membangun ulang image dan menjalankan kontainer.
build:
	@echo "🏗️  Membangun ulang image dan menjalankan layanan..."
	@docker compose up -d --build --force-recreate

## reset: Menghentikan kontainer dan MENGHAPUS SEMUA VOLUME (termasuk database).
reset:
	@echo "💣 Menghentikan layanan dan menghapus semua data volume..."
	@docker compose down -v

# ==============================================================================
# PERINTAH APLIKASI
# ==============================================================================

## artisan: Menjalankan perintah Artisan. Contoh: make artisan cmd="migrate"
artisan:
	@echo "Running: php artisan $(cmd)..."
	@docker compose exec app php artisan $(cmd)

## composer: Menjalankan perintah Composer. Contoh: make composer cmd="require laravel/breeze"
composer:
	@echo "Running: composer $(cmd)..."
	@docker compose exec app composer $(cmd)

## npm: Menjalankan perintah NPM. Contoh: make npm cmd="install"
npm:
	@echo "Running: npm $(cmd)..."
	@docker compose exec vite npm $(cmd)

# ==============================================================================
# UTILITAS & DEBUGGING
# ==============================================================================

## logs: Melihat log dari sebuah layanan. Contoh: make logs s=app (default: app)
logs:
	@echo "🔎 Menampilkan log untuk layanan: $(s)..."
	@docker compose logs -f $(s)

## shell: Masuk ke terminal (shell) kontainer 'app' sebagai user www-data.
shell:
	@echo "💻 Masuk ke shell kontainer 'app'..."
	@docker compose exec app sh

## shell-root: Masuk ke terminal (shell) kontainer 'app' sebagai user root.
shell-root:
	@echo "👑 Masuk ke shell kontainer 'app' sebagai ROOT..."
	@docker compose exec --user root app sh

## help: Menampilkan bantuan ini.
help:
	@echo "Perintah yang tersedia:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

