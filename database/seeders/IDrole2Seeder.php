<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IDrole2Seeder extends Seeder
{
    public function run()
    {
        $password = '$2y$10$mg3BURvucuvIXI2Rfo06/.5c/zUwNGriOKeHOn.4UFJ4LwUMx7.SS';

        DB::table('users')->insert(array_map(function ($user) use ($password) {
            $user = array_combine([
                'id', 'nama', 'nip', 'username', 'password',
                'remember_token', 'id_role', 'status', 'created_at', 'updated_at',
            ], $user);

            $user['password'] = $password;

            return $user;
        }, [
            [8, 'Pengawas Umum 3', null, 'pengawas3', '$2y$10$hwXXCaL4ujSnnyG.XBCX3ONq3eWCj5i8NLKk5QAP9CoHO1uVQYTei', null, 2, 1, '2021-09-16 23:13:17', '2026-09-09 05:04:55'],
            [21, 'Ns. Devi A.C.SKeP', '0', '0', '$2y$10$8Uu81F23LiZQmaRbiA/cf.6/Uus3qmSgYY9ZEjLOk.qVgwdxwfhlK', null, 2, 0, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [22, 'Ns. Imelda Manik SKeP', null, '0', '$2y$10$zYQFS2Lo4VHAp9O12R3T2ugcMkQx305k.sTPMJFHjYknsXifpZgsu', null, 2, 0, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [23, 'Agustina Soge AMdK', '0', '0', '$2y$10$P0R3feang6yMENUPJ4VXSeSjk1tVrav18lxOwbiGVz7sj8pIOHhzG', null, 2, 0, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [24, 'Herlina Sidabariba', '0', '0', '$2y$10$zgov2ZKZXPORpdBIRaN1aeX1GiNTb78nwkqIP333sOsdQrFCxbU6y', null, 2, 0, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [25, 'Ns. Suparni Sijabat Skep', '0', '0', '$2y$10$9UoJPyJsmUGnQZ1kOJTWG.R6MAmJyoPvlH9w52IQQ14JgxpKsMVQW', null, 2, 0, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [26, 'Rostina Sihite', '392', 'pengawas0392', '$2y$10$28rSb.kkn5e8w8DxOoEQ1ufe0U40w0FRu7FJsH6wB1HnXOSxy/PHy', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [27, 'Dewi Goretti', '513', 'pengawas0513', '$2y$10$1SY9FfdvEPzE9KfcrKvQDuWpu6fDB3e2Z3hJXIuAvA8tnQ5p9OO3q', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [28, 'Martha Rosude', '630', 'pengawas0630', '$2y$10$fvnFqNwnQoc43YCHbK.tD.PNm9slTro9SIRsK6crE0lF9DvgWteWG', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [29, 'Agnes Monalisa', '0', '0', '$2y$10$zYQFS2Lo4VHAp9O12R3T2ugcMkQx305k.sTPMJFHjYknsXifpZgsu', null, 2, 0, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [30, 'Magdalena Pane', '459', 'pengawas0459', '$2y$10$KUDxg63/S8R69k8.7Dv5PuS1gMuHgE4X/xc97GKUFuKICoJZn9/WC', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [31, 'Ns. Nidya Ayu Nicke SKeP', '0', '0', '$2y$10$Yl0CWh3IQPs7yGlMx0v/5OBydua68DB4IgX1AHH07bIe5MXhDVcnq', null, 2, 0, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [32, 'Gusrida', '490', 'pengawas0490', '$2y$10$6mBsBpLzaRmFzdylHMRuoutqrUxwlEdDj.zpKlxKQuWEbZxXeLw0S', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [33, 'Netty Sumarni L', '511', 'pengawas0511', '$2y$10$1Oj1zgll/cos42xppmX1euXPztC8OPJeysDDHLgAwYt1nZm6xxTGe', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [34, 'Asmaul Husni Trisni', '1151', 'pengawas1151', '$2y$10$DPfjoXbYSIncsvFE3W0sIeoEbkFXkOG6OrCFBu/a1WSNX/W3Tno8e', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [35, 'Sediana Shinta Marbun', '380', 'pengawas0380', '$2y$10$Imf.d7UMymt0H6W0PntuiOA9opGuE52MJs3sWBO9hc3M7szNXQUXy', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [36, 'Rusmiati Turnip', '643', 'pengawas0643', '$2y$10$wEvIGiFBk7V8i1R322GCVe1zNOUo4DA4VUDVZTvHE9MrKAs.WI/oS', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [37, 'Eka Nofrita', '700', 'pengawas0700', '$2y$10$XgnbN//AeG0WXj8EApPzfuI/ApjtDStQnHJsmC/zQIAiKVZjPcZw2', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [38, 'Erlina Silalahi', '489', 'pengawas0489', '$2y$10$AgDj1Uf2fZ5/n2AT/XZEFuDt3wAtSZ0SMqc94uG.GpMjweV8UjCL2', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [39, 'Juliana Dame', '788', 'pengawas0788', '$2y$10$xXw3RoR91niCp59bQweNqeIJKWyB2Fsqair5IAttycfFJLvOX2tQ6', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [40, 'Mawarni', '0', '0', '$2y$10$Xemi2bqsKesberMN//AhreZ35mH.ZkP6fO4U.IplDq87vAj96J.xu', null, 2, 0, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [41, 'Nani Sri Mulya', '794', 'pengawas0794', '$2y$10$muWGmpUvaJJ0GK1uRYQMiePDTpz/lLkehbO.x3iBSuLW5adP..8o6', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [42, 'Benedikta Eni K', '553', 'pengawas0553', '$2y$10$fgRgKakBW8ATIuHn9iRs6.buF48GinR9Ox55CW4P5gO.TXxejeXvW', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [43, 'Betaria Sonat', '0', '0', '$2y$10$qZVQTGtMygusEHxjlgZIouYXhFmaUX8vbtY9lKxIIeOLAtXGJQiEW', null, 2, 0, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [44, 'Nerli Tekla', '565', 'pengawas0565', '$2y$10$ytieQuka2xDFaEWQslrYMu74eCS69uFoVMd.WoKmkvUoi2xJ0kZvu', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [45, 'Yuliawati', '578', 'pengawas0578', '$2y$10$cMyrzDHVh.CyJrFHDKfmWe3rC/e4pqJ8.EBHXQQLQGap1scf2kfOe', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [46, 'Betty Elisabeth M', '474', 'pengawas0474', '$2y$10$Q.Oneziw7r0T5zeui.OHA.DBMr/vIMzfVv.zBCAOxE8xXB/OMANDG', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [47, 'Ns. Denny R Silaen SKeP', '0', '0', '$2y$10$2TaERFHz/M66E34k9TVsxOUpbTI0IWWBGFlN7TMocPJORUfGz.rvm', null, 2, 0, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [48, 'Andri Rotua', '628', 'pengawas0628', '$2y$10$Yej3LXZhiG8VM0nQQE5bBO60rga1.2dfh/tdEgtzRDjHzurrWvKfe', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [49, 'Sri Nova Eka Putri', '697', 'pengawas0697', '$2y$10$jJV41.aQG0PXxCHncu/I.eEaQ3Vr2H0i4Uy.4oFgjX0Y9NxQnqu7m', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [50, 'Adri Yosep', '571', 'pengawas0571', '$2y$10$ZZrNBiYcdTXldsPyHtWcMeA7CJv3o3dRCzHRzJ/Bfz.BwUpt0Giti', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [51, 'Tiara Manurung', '442', 'pengawas0442', '$2y$10$6j12Uu80ccBFjDuJF1UuhedL5vNs0y8AnCKYec1O1U021vzrEEq0q', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [52, 'Blasius Pati Libunaen', '586', 'pengawas0586', '$2y$10$tcNRRsBWDK4c90/yuo/lB.INK.s.LopkD0MBkgNSsP6G/w7x9yQ8i', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [53, 'Evalin Erwin', '533', 'pengawas0533', '$2y$10$cmBFxfTul6VncwyMzPaNNehmdDJ6wcDYAzx8j3TtmAIqDhCKP3pJC', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [54, 'Ns. Maria Sijabat SKeP', '534', 'pengawas0534', '$2y$10$Z6fhjTqDfShxg7lCDcy/wuwZj7BF0fx9xVzfFXQ7o9H8GNbGuIF0m', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [55, 'Yulianawati', '366', 'pengawas0366', '$2y$10$8/PKexArFdYjo7h6D9lafe4wzSkFX4PGOWb89KOcnX3nsUgdJWn/S', null, 2, 1, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [56, 'Irvan Sianturi', '0', '0', '$2y$10$BDbm.dLM64e7O26Ij9A0Tu4AA6BunEosfAr4VJbybvJECbAOfL4c2', null, 2, 0, '2021-10-17 13:36:17', '2026-09-09 05:04:55'],
            [57, 'agnesh monalisa sagala', '597', 'pengawas0597', '$2y$10$YhnG96N/jwrGWVyNaFe4rO0pCsOzMDJmfAdNfPMc4cF28nxMBkeu2', null, 2, 1, '2021-10-18 12:30:33', '2026-09-09 05:04:55'],
            [58, 'EDP', null, 'edp', '$2y$10$vboaiOBbcldmvAShPJW3C.m5AUV3xd3LPs9Dge96iLZw3Ef4wnl5G', null, 2, 1, '2021-10-30 09:49:01', '2026-09-09 05:04:55'],
            [59, 'Harmonika Malau', '515', 'Pengawas0515', '$2y$10$wKyfDFmBDMAiJMjxbqlYxOpWAQTt40O8MBkGf/hJ15eDFV6fP.yLG', null, 2, 1, '2021-11-08 10:35:06', '2026-09-09 05:04:55'],
            [60, 'Ns. Nora Yetti Sinaga', '1177', 'pengawas1177', '$2y$10$cUPGiDx/X9dxKdjL3q3npexv513TDJDLQay77qhmoOIh37SVwDkfS', null, 2, 1, '2022-01-25 08:07:54', '2026-09-09 05:04:55'],
            [61, 'Sumiharyanti Natalia Rezeki Putri Sijabat', '1344', 'pengawas1344', '$2y$10$7BJxe71p4C.Yu6ScnPobKOBqoJEKlW993FOM58r9m7VslF1Htlj1O', null, 2, 1, '2022-01-26 08:31:43', '2026-09-09 05:04:55'],
            [62, 'Zulvia Dewinta', '1077', 'pengawas1077', '$2y$10$VaOusINk1TaKnTBQ1Ui3VeMDaNytQOcMoKCGNnKuM5GDkEPwVh4TK', null, 2, 1, '2022-01-26 14:43:28', '2026-09-09 05:04:55'],
            [65, 'Charly Novalia Putri', '1247', 'pengawas1247', '$2y$10$8mDpmxnHGUYvm/gmXxQXsuLfUU33lUyhJ7mB621AuxKFUTZIXJ2jy', null, 2, 1, '2022-03-28 07:57:57', '2026-09-09 05:04:55'],
            [66, 'Yelvia Yufri Yanti', '0836', 'pengawas0836', '$2y$10$4vmWY.WcKPsYsi/eK.JKsePXWQ0qaABoReDS2g6J3nBImRopgygcK', null, 2, 1, '2022-03-28 07:59:12', '2026-09-09 05:04:55'],
            [67, 'Meilan Rismawaty', '396', 'pengawas0396', '$2y$10$VfHWaiTttKC4IVQACboPb.O1FDE09IBMJ5Zno17PGDpetR4rmV74.', null, 2, 1, '2022-03-28 08:06:25', '2026-09-09 05:04:55'],
            [68, 'Dian Rahmadani', '0', '0', '$2y$10$qL8zY8fJ60N1AqGYwoJqdudCWAMXmL/ClPAonupB505zU5WxUpdqi', null, 2, 0, '2022-03-28 08:07:19', '2026-09-09 05:04:55'],
            [69, 'Mesrahwati Zai', '640', 'pengawas0640', '$2y$10$rE4svgyptCWgm/rlZj7eEeZ7EpSt4oMuVfuOriGFUe7VXpWc7xchy', null, 2, 1, '2022-03-28 08:08:41', '2026-09-09 05:04:55'],
            [70, 'Novia', '1498', 'pengawas1498', '$2y$10$RV2RjFQVjwvswAWeFR8sPOgGJz11Vt8hyrvqUkeSCJSl5uYUUPdgK', null, 2, 1, '2022-03-28 08:09:15', '2026-09-09 05:04:55'],
            [71, 'Ririn Septrina', '826', 'pengawas0826', '$2y$10$MiIoIY15pzb9W6f7uTVoXeYJXBSL5MogRHDoOunzFW6lDVIvSwga.', null, 2, 1, '2022-03-28 08:10:30', '2026-09-09 05:04:55'],
            [72, 'Ester Maranata Nababan', '1057', 'pengawas1057', '$2y$10$5EbnOZKd5JC5Z4gxleutZulutMPmo7VDenhFgAC0GtIKhHohUIplS', null, 2, 1, '2022-03-28 08:11:22', '2026-09-09 05:04:55'],
            [73, 'Herlina Sidabariba', '0', '0', '$2y$10$hdAr4Awlx5hn57q8O/YwJuUenm9DTiqWQKGLkck9b1NC9c1VQ2CRS', null, 2, 0, '2022-05-07 07:02:59', '2026-09-09 05:04:55'],
            [74, 'malvin', '0', '0', '$2y$10$5fsDL4E2Ujw/fIkEb3mAqeVNrXsla1Mj6JFb.L8q6V/6yON0/3Dv2', null, 2, 0, '2022-05-30 12:53:09', '2026-09-09 05:04:55'],
            [75, 'marliana sembiring', '0', '0', '$2y$10$kdoVMlPrUoa9tVOikju75eO2ef1BAZgrXGEX6eBohvboxzYKyFV0y', null, 2, 0, '2022-06-27 07:50:13', '2026-09-09 05:04:55'],
            [76, 'ega rahmi jelvita', '1249', 'pengawas1249', '$2y$10$ixj8qhB0KIsfjsjVm./5Ieqk71XjcvCoint99Oack9dt0SltS8LcO', null, 2, 1, '2022-08-04 09:09:54', '2026-09-09 05:04:55'],
            [77, 'olva jasela', '1229', 'pengawas1229', '$2y$10$4q8tI7mt8PSC4opTddY8ae7KcvoAvx5CyX6.HhD3VG8z2uVKq8ym6', null, 2, 1, '2022-08-04 09:19:13', '2026-09-09 05:04:55'],
            [78, 'renita situmorang', '0514', 'pengawas0514', '$2y$10$7Ch3TjCxOPjksrfvqXgNa.dpC45FB6EjReWoFwA9Q5/a3MKmMcSeS', null, 2, 1, '2022-08-04 09:30:34', '2026-09-09 05:04:55'],
            [79, 'debora adventia sabojiat', '1112', 'pengawas1112', '$2y$10$ktyjd/3IT.yyixqd7UXNU.eOuKXQlzzxcBmXSWwaMOSWLYONUhplO', null, 2, 1, '2022-08-04 09:31:52', '2026-09-09 05:04:55'],
            [80, 'Dian Rahmadani', '1236', 'pengawas1236', '$2y$10$DyRv2vHuIH3IBKZwZi5itOtiKoU0phntwxYvNC7Ul599gUKNyOMSa', null, 2, 1, '2023-01-17 15:01:40', '2026-09-09 05:04:55'],
            [82, 'kep', '9897', 'kep', '$2y$10$q9fQ3x7D6UAyHE7ZCPE7dOoA.SmjK7KXjlL3lWufGmIEgvn8nnhWa', null, 2, 1, '2023-11-28 08:34:52', '2026-09-09 05:04:55'],
            [83, 'nova novianti', '1239', 'pengawas1239', '$2y$10$1ZGFdQMnOmZvPFU9/fJ./.H6hV9x0z/Rg19rnuiMKE1aAw4tfZpIy', null, 2, 1, '2023-12-04 11:59:25', '2026-09-09 05:04:55'],
            [84, 'bernadeth selvia', '1408', 'pengawas1408', '$2y$10$3uQrPDwGeFDEUBc/xs77hO87c/DI774NeEH61yBuZd4hSgzPHee8O', null, 2, 1, '2023-12-04 11:59:50', '2026-09-09 05:04:55'],
            [85, 'Anggryeny Sahanas', '1306', 'pengawas1306', '$2y$10$FH94KSlbllQtNEuEyTfh/OhqSXY7riIKrJWxpLsCf.aS4LX63..G.', null, 2, 1, '2023-12-04 12:00:17', '2026-09-09 05:04:55'],
            [86, 'ervina', '1104', 'pengawas1104', '$2y$10$I6VO3pyXa.Tuc/6jzkrUne90TYzs5sBaKmSpF006btHhQPac4qYoG', null, 2, 1, '2023-12-04 12:00:47', '2026-09-09 05:04:55'],
            [87, 'FABER VERAWATY SIAHAAN', '1211', 'pengawas1211', '$2y$10$FeNkiLVUAN4q6Wr0kk2ew.dMoyfVQLURzZVtOqkdwkz7EQ1c9N8c2', null, 2, 1, '2023-12-04 12:01:25', '2026-09-09 05:04:55'],
            [88, 'Rusmawati sijabat', '1578', 'pengawas1578', '$2y$10$PJyqGaqNGk3dxMjF9gWK.eHbklqo1MiPV7g4J/tRcweqRF7j6CQz6', null, 2, 1, '2023-12-04 12:02:02', '2026-09-09 05:04:55'],
            [89, 'Agnes Tiyas Sito Resmi', '1354', 'pengawas1354', '$2y$10$yb0C1R45iQo5oaq.B.Eb8uKg4f8BT4si1mdJRrSFzihI7390t2NjC', null, 2, 1, '2023-12-04 12:02:31', '2026-09-09 05:04:55'],
            [90, 'rika silvia', '1436', 'pengawas1436', '$2y$10$4FA2QEN4Nw/IDQXGlwGZLOv.SOKmVBR3HhikzzbAvtCw1O6skoPai', null, 2, 1, '2023-12-04 12:03:40', '2026-09-09 05:04:55'],
            [91, 'Yuni Sari Ramadhani', '1577', 'pengawas1577', '$2y$10$oU82lMeeh3.QwbbwJw.LYe1reZobffOwsy943o8N5Kj9mXQJhNeU6', null, 2, 1, '2023-12-04 12:04:20', '2026-09-09 05:04:55'],
            [92, 'ros endang susilawati samosir', '934', 'pengawas934', '$2y$10$jVHdqe9YQWw5nXYw/Qt5R.FSSbFBUMrTHKlBJkS1GIAvg9TT8t4uq', null, 2, 1, '2023-12-04 12:05:06', '2026-09-09 05:04:55'],
            [93, 'yohanes suban raya', '1432', 'pengawas1432', '$2y$10$ss9qBbkinnws7sWaT7tqmuDxz0DD1lT8Ogvf4YyZiDMhhih5LDRoO', null, 2, 1, '2023-12-04 12:05:37', '2026-09-09 05:04:55'],
            [94, 'Irma Apriyenita Marpaung', '1312', 'pengawas1312', '$2y$10$5i2o0tElKwqVLUaGBFgVfecbybnK.diDhxXW2zPKD9kfoioH1ejRW', null, 2, 1, '2023-12-21 13:06:23', '2026-09-09 05:04:55'],
            [95, 'Tri Wahyuni', '1591', 'pengawas1591', '$2y$10$bl88.LXuNr.5gmr404wmJebpnahPdJ6zI1lBB9dpYX5TLk6vvSVGO', null, 2, 1, '2024-01-11 07:38:11', '2026-09-09 05:04:55'],
            [97, 'Setiawati', '313', 'pengawas313', '$2y$10$IT38GhJUVO3EJvif4fEHNeRPmnvFIBkiumqUXr8HDBxIgDAQTLDq.', null, 2, 1, '2024-05-20 08:18:23', '2026-09-09 05:04:55'],
            [98, 'Herlina Sidabariba', '0', '0', '$2y$10$qW8UsAV2ny6wCChVNhjJaev.UxYkqZgu.nKVflgR0v4jeqRD8ehJe', null, 2, 0, '2024-05-28 11:54:30', '2026-09-09 05:04:55'],
            [99, 'Herlina Sidabariba', '540', 'pengawas540', '$2y$10$Z0yscI2IE0fH7QyI4jUZmu6tHxgInPo1CEGrslTGuDtHIgTwVLDm.', null, 2, 1, '2024-05-28 12:05:06', '2026-09-09 05:04:55'],
            [100, 'Ns. Nidya Ayunicke, S.Kep', '1187', 'pengawas1187', '$2y$10$VfvnoPrsE.8LtFNoUh3K8OPhZKmWNcSoUYF9oXn8puZtDC0HpK4/S', null, 2, 1, '2024-05-29 16:25:07', '2026-09-09 05:04:55'],
            [101, 'Pelitaria Hia', '1293', 'pengawas1293', '$2y$10$1XvTqmPnl..2zDf1xSToee1ikopXkPUTOv8gxj9dKc6DBeD.Y658O', null, 2, 1, '2024-09-26 09:42:17', '2026-09-09 05:04:55'],
            [102, 'Muhammad Vikhi Ramadoni', '977', 'pengawas977', '$2y$10$l3UyhdusqZDDoeoSlmnUMerWa/NCUmGYYm33pfeiracHYi8vsO2lK', null, 2, 1, '2024-09-30 08:20:21', '2026-09-09 05:04:55'],
            [103, 'Yoseph Samin Sanonce Anin', '1611', 'pengawas1611', '$2y$10$sUc0tx6JbO44mLa8PCCjxuv9OAOWhhbqwJGwsq1M7WGQaxSc9hI52', null, 2, 1, '2024-09-30 08:21:08', '2026-09-09 05:04:55'],
            [104, 'Y. Paraswari', '1030', 'pengawas1030', '$2y$10$woFgxtmW14AfmrBv0.0iG.Hidod59gMMG7yT87cmJ5btyNhZPnljW', null, 2, 1, '2024-09-30 08:21:38', '2026-09-09 05:04:55'],
            [105, 'Gusnita', '654', 'pengawas654', '$2y$10$KWOS9jsdCNkwKWV2PQ/7AOxex4DECc6bkdYr4xJgm7MPoJZ/hLOV2', null, 2, 1, '2025-02-01 13:02:34', '2026-09-09 05:04:55'],
            [107, 'Rohani Raja Guk Guk', '394', 'pengawas394', '$2y$10$ieLevXlqMDmeggH9bffGdumo/VzlQBDD91JABUdfLS7raEa3U6s8u', null, 2, 1, '2025-09-16 13:32:16', '2026-09-09 05:04:55'],
            [108, 'Mariana Yulianti Diaz', '1364', 'pengawas1364', '$2y$10$YbYQ0dc.Xprf.XCzuZCdVuZWOM/rHBxOd3S13iPCxlpvPa6lOy/Fy', null, 2, 1, '2026-01-26 12:27:49', '2026-09-09 05:04:55'],
            [109, 'Fiska Sriyunima Ningsih', '1700', 'pengawas1700', '$2y$10$JkAPuYaImnk0mzyMouF9ZuLTgeLxoCUqXIZGyBrzIZIJmY7urrhQe', null, 2, 1, '2026-01-26 12:28:53', '2026-09-09 05:04:55'],
            [110, 'Margareta Erni Simanjuntak', '1619', 'pengawas1619', '$2y$10$rtIyB2/m1xsPOdEzI9eWeOh1dtVMOaRiA5mwlYo9KteiT3ktMvvky', null, 2, 1, '2026-01-26 12:30:00', '2026-09-09 05:04:55'],
            [111, 'Vivi Gusmita', '1082', 'pengawas1082', '$2y$10$Em2l3U4qw/DPXT.f.Tk8kO3uVZIL2pNsbUG3WlfTs1rVWPrs0QRa6', null, 2, 1, '2026-01-26 12:37:47', '2026-09-09 05:04:55'],
            [112, 'Elsa Wulan Sari', '1517', 'pengawas1517', '$2y$10$Di7H1Rg/WvuwwwH0Jbkd5.RnhKMMw7kt0HZjVnBy4IYmsPLD42xgW', null, 2, 1, '2026-01-26 12:38:28', '2026-09-09 05:04:55'],
            [113, 'Sil Oktavia', '1277', 'pengawas1277', '$2y$10$eD6z3WfMkTdTXcE7LPfcF.d97iSuv1mc5dsD4qvhLpqY4soraGS.W', null, 2, 1, '2026-02-09 09:54:30', '2026-09-09 05:04:55'],
        ]));
    }
}
