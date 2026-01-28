from config import get_connection

def tampilkan_buku():
    conn = get_connection()
    cursor = conn.cursor()
    query = "SELECT * FROM buku"
    cursor.execute(query)
    results = cursor.fetchall()
    
    print("\n=== DAFTAR BUKU ===")
    print(f"{'ID':<5} {'Judul':<30} {'Harga':<15} {'Stok':<5}")
    print("-" * 60)
    for row in results:
        print(f"{row[0]:<5} {row[1]:<30} Rp{row[3]:<15} {row[4]:<5}")
    
    cursor.close()
    conn.close()

def tambah_buku(judul, penulis, harga, stok):
    conn = get_connection()
    cursor = conn.cursor()
    query = "INSERT INTO buku (judul, penulis, harga, stok) VALUES (%s, %s, %s, %s)"
    val = (judul, penulis, harga, stok)
    cursor.execute(query, val)
    conn.commit()
    print(f"Buku '{judul}' berhasil ditambahkan!")
    cursor.close()
    conn.close()