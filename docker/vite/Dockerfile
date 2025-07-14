# Gunakan base image Node.js
FROM node:20-alpine

# Install curl (untuk mengambil data dari API) dan jq (untuk mem-parsing JSON)
RUN apk add --no-cache curl jq

# Set direktori kerja
WORKDIR /var/www

# Salin script entrypoint yang akan kita buat nanti
COPY ./docker/vite/entrypoint.sh /usr/local/bin/entrypoint.sh
# Berikan izin eksekusi pada script
RUN chmod +x /usr/local/bin/entrypoint.sh

# Atur agar script ini dijalankan saat kontainer dimulai
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
