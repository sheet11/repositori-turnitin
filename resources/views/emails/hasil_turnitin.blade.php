<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Hasil Pengecekan Turnitin</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:6px; overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color:#0b5394; padding:20px 30px;">
                            <h2 style="color:#ffffff; margin:0; font-size:18px;">
                                Perpustakaan Poltekkes Kemenkes Bengkulu
                            </h2>
                            <p style="color:#d9e6f2; margin:4px 0 0; font-size:13px;">
                                Layanan Pengecekan Plagiarisme (Turnitin)
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:30px;">
                            <p style="font-size:14px; color:#333333; margin-top:0;">
                                Yth. Saudara <b>{{ $data['nama'] }}</b>,
                            </p>

                            <p style="font-size:14px; color:#333333; line-height:1.6;">
                                Dengan hormat, kami sampaikan bahwa proses pengecekan kemiripan dokumen (similarity check)
                                terhadap karya tulis Anda telah selesai dilakukan oleh sistem Turnitin Perpustakaan
                                Poltekkes Kemenkes Bengkulu. Berikut adalah ringkasan hasil pengecekan:
                            </p>

                            <table width="100%" cellpadding="8" cellspacing="0" style="background-color:#f9f9f9; border:1px solid #e0e0e0; border-radius:4px; margin:20px 0; font-size:14px; color:#333333;">
                                <tr>
                                    <td width="35%" style="font-weight:bold; border-bottom:1px solid #e0e0e0;">Judul Dokumen</td>
                                    <td style="border-bottom:1px solid #e0e0e0;">{{ $data['judul'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold;">Similarity Index</td>
                                    <td>
                                        <span style="background-color:#0b5394; color:#ffffff; padding:3px 10px; border-radius:4px; font-weight:bold;">
                                            {{ $data['similarity_index'] }}%
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:14px; color:#333333; line-height:1.6;">
                                Untuk melihat laporan hasil pengecekan secara lengkap, silakan masuk (login) ke sistem
                                informasi Perpustakaan menggunakan akun resmi Anda.
                            </p>

                            <p style="text-align:center; margin:30px 0;">
                                <a href="http://180.250.37.238:8083/login" target="_blank"
                                   style="background-color:#0b5394; color:#ffffff; text-decoration:none; padding:12px 28px; border-radius:4px; font-size:14px; font-weight:bold; display:inline-block;">
                                    Lihat Laporan Lengkap
                                </a>
                            </p>

                            <p style="font-size:14px; color:#333333; line-height:1.6;">
                                Apabila Anda mengalami kendala dalam mengakses sistem atau memerlukan informasi lebih
                                lanjut, silakan menghubungi petugas Perpustakaan Poltekkes Kemenkes Bengkulu.
                            </p>

                            <p style="font-size:14px; color:#333333; margin-bottom:0;">
                                Demikian informasi ini kami sampaikan. Atas perhatian dan kerja samanya, kami ucapkan
                                terima kasih.
                            </p>
                        </td>
                    </tr>

                    {{-- Signature --}}
                    <tr>
                        <td style="padding:0 30px 30px;">
                            <p style="font-size:14px; color:#333333; margin:0;">
                                Hormat kami,<br>
                                <b>Unit Perpustakaan</b><br>
                                Politeknik Kesehatan Kemenkes Bengkulu
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color:#f0f0f0; padding:15px 30px; text-align:center;">
                            <p style="font-size:11px; color:#888888; margin:0;">
                                Email ini dikirim secara otomatis oleh sistem. Mohon untuk tidak membalas email ini.
                            </p>
                            <p style="font-size:11px; color:#888888; margin:4px 0 0;">
                                © {{ date('Y') }} Politeknik Kesehatan Kemenkes Bengkulu — Jl. Indragiri No. 03, Padang Harapan, Bengkulu
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>