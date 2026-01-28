import operations as ops

def main():
    while True:
        print("\n=== APLIKASI TOKO BUKU (UAS) ===")
        print("1. Tampilkan Buku (Read)")
        print("2. Tambah Buku (Create)")
        print("3. Keluar")
        
        pilihan = input("Pilih menu: ")
        
        if pilihan == "1":
            ops.tampilkan_buku()
        elif pilihan == "2":
            judul = input("Judul: ")
            penulis = input("Penulis: ")
            harga = int(input("Harga: "))
            stok = int(input("Stok: "))
            ops.tambah_buku(judul, penulis, harga, stok)
        elif pilihan == "3":
            print("Terima kasih.")
            break
        else:
            print("Pilihan tidak valid.")

if __name__ == "__main__":
    main()