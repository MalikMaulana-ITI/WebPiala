#!/bin/sh

# Hentikan script jika ada perintah yang gagal
set -e

echo "Menunggu layanan Ngrok siap..."

# Terus-menerus cek hingga API Ngrok memberikan URL publik
NGROK_URL=""
while [ -z "$NGROK_URL" ]; do
  sleep 2
  # Ambil URL dari API Ngrok menggunakan curl dan jq
  # 'ngrok' adalah nama layanan di docker-compose.yml
  NGROK_URL=$(curl -s http://ngrok:4040/api/tunnels | jq -r '.tunnels[] | select(.proto=="https") | .public_url')
done

echo "✅ URL Publik Ngrok ditemukan: $NGROK_URL"

# Export URL sebagai environment variable agar bisa digunakan oleh Vite
export VITE_SERVER_HOST=$NGROK_URL
export APP_URL=$NGROK_URL

# Jalankan perintah asli untuk Vite
echo "Menginstall dependensi NPM (jika perlu)..."
npm install

echo "🚀 Memulai server Vite dengan HMR..."
# 'exec' akan menggantikan proses script dengan proses npm
exec npm run dev -- --host
