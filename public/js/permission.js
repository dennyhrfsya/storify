(function () {
    const initHakAkses = () => {
        const container = document.getElementById('permissions-container');
        if (!container) return;

        const url = container.dataset.url;
        const token = container.dataset.csrf;

        document.querySelectorAll('.perm-check').forEach(el => {
            // Hindari double binding jika script terpanggil 2x
            if (el.getAttribute('data-bound')) return;
            el.setAttribute('data-bound', 'true');

            el.addEventListener('change', async e => {
                const target = e.target;

                try {
                    const response = await fetch(url, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "Content-Type": "application/json",
                            "Accept": "application/json" // Memastikan Laravel kirim balik JSON
                        },
                        body: JSON.stringify({
                            role: target.dataset.role,
                            module: target.dataset.module,
                            field: target.dataset.field,
                            value: target.checked ? 1 : 0
                        })
                    });

                    // VALIDASI RESPONSE: Cek apakah server kirim error (404, 500, dll)
                    // if (!response.ok) {
                    //     const errorData = await response.json();
                    //     throw new Error(errorData.message || `Server Error: ${response.status}`);
                    // }

                    // --- PERBAIKAN VALIDASI RESPONSE ---
                    if (!response.ok) {
                        // Cek apakah response berupa JSON atau teks/HTML
                        const contentType = response.headers.get("content-type");
                        if (contentType && contentType.includes("application/json")) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || `Server Error: ${response.status}`);
                        } else {
                            const errorText = await response.text(); // Ambil HTML mentah jika server error
                            console.error("Detail Error HTML dari Server:", errorText);
                            throw new Error(`Server status ${response.status}. Lihat Console untuk detail HTML.`);
                        }
                    }

                    const data = await response.json();
                    console.log("Updated Success:", data);

                } catch (error) {
                    // TANGKAP ERROR: Agar tidak muncul "Uncaught in promise"
                    console.error("Gagal Update:", error.message);

                    // Kembalikan posisi checkbox ke semula karena gagal di server
                    target.checked = !target.checked;

                    alert("Gagal memperbarui hak akses: " + error.message);
                }
            });
        });
    };

    document.addEventListener('DOMContentLoaded', initHakAkses);
})();
