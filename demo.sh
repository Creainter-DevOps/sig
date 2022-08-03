#!/bin/bash
export PATH="$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin"
echo "Respaldando Carpeta..."
export PATH="$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin"
cd /tmp/
tar -zcvf 'doc-workspace-1220.tar.gz' 'doc-workspace-1220/'
/snap/bin/gsutil mv 'doc-workspace-1220.tar.gz' 'gs://creainter-peru/storage/workspace/doc-workspace-1220.tar.gz'
echo "Se ha iniciado el proceso..."
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/firma_1_2.png' '/tmp/doc-workspace-1220/e8bba6320b18daf28f812b0eb8b197a3.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/firma_1_3.png' '/tmp/doc-workspace-1220/7a309f2392e814a032bf9528ccbe4b8c.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/firma_1_4.png' '/tmp/doc-workspace-1220/6937afd416191648b839d085c3f35120.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/firma_1_5.png' '/tmp/doc-workspace-1220/3a4b1af8c9bdd509ec691fed8d7a13c4.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/firma_1_6.png' '/tmp/doc-workspace-1220/7e7c50e7118fdf3f9edce81a4a27720f.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/firma_1_7.png' '/tmp/doc-workspace-1220/cc0350773dc9eca7cbc0dbad8808623a.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/firma_1_8.png' '/tmp/doc-workspace-1220/af5113ed0b0863429c93fc61cb323875.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/firma_1_9.png' '/tmp/doc-workspace-1220/3b5e6cda625c365327a64dc4ef5ddeb0.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/firma_1_10.png' '/tmp/doc-workspace-1220/a36a77ea12ad368f33c588c457a9609e.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/firma_1_11.png' '/tmp/doc-workspace-1220/49b1d8ca46c8f598af9417c7376a4e93.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_2.png' '/tmp/doc-workspace-1220/b7fc1edf16b75258fad65c9966714e46.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_3.png' '/tmp/doc-workspace-1220/a1b7ef04ae2f53bc50f3e79db9e82640.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_4.png' '/tmp/doc-workspace-1220/e9fb351ebda9ac8e6e1a5a8526a15552.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_5.png' '/tmp/doc-workspace-1220/fe91630765b0fda569d7ef3475c75bcf.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_6.png' '/tmp/doc-workspace-1220/2cd85a268746878f6aa9ca83a3ff1897.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_7.png' '/tmp/doc-workspace-1220/c7619b7dc269f27b9e5a917509afc260.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_8.png' '/tmp/doc-workspace-1220/efafe32a514b152aed0b50a0c85c806c.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_9.png' '/tmp/doc-workspace-1220/d461ad2cefd890b63df02f50ef02fb52.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_10.png' '/tmp/doc-workspace-1220/22d0af743de26e05d05bd86f989710a1.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_11.png' '/tmp/doc-workspace-1220/11bfd0a9887802788621468ab99c6e05.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_12.png' '/tmp/doc-workspace-1220/a938dbacdc3ee2d50c1eda194da2cda6.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_13.png' '/tmp/doc-workspace-1220/40d4eb766a52b7b62859879161dc8279.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_14.png' '/tmp/doc-workspace-1220/ff62bc48c30a9e7e891e23531e541e71.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_15.png' '/tmp/doc-workspace-1220/f92b85b14d9b0c960e790c41719f68ee.png'
/snap/bin/gsutil cp 'gs://creainter-peru/storage/FIRMAS/visado_1_16.png' '/tmp/doc-workspace-1220/1f326b4125087f7adbdcfb4811c442a8.png'
echo "Proceso de separación de PDF"
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/ANEXO-01.pdf' '/tmp/doc-workspace-1220/62e032f6c701d-%d.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e032f6c701d-1.pdf /tmp/doc-workspace-1220/b7fc1edf16b75258fad65c9966714e46.png 0.11605 0.91297 '/tmp/doc-workspace-1220/62e032f6c701d-1.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e032f6c701d-1.pdf /tmp/doc-workspace-1220/e8bba6320b18daf28f812b0eb8b197a3.png 0.4688449848024316 0.6588490061083986 '/tmp/doc-workspace-1220/62e032f6c701d-1.pdf'
echo "Proceso de separación de PDF"
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/d21ed9ad62f7027879c23caf8398affe.pdf' '/tmp/doc-workspace-1220/62e03340f1aee-%d.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e03340f1aee-1.pdf /tmp/doc-workspace-1220/a1b7ef04ae2f53bc50f3e79db9e82640.png 0.09498480243161095 0.9447375413573792 '/tmp/doc-workspace-1220/62e03340f1aee-1.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e03340f1aee-2.pdf /tmp/doc-workspace-1220/e9fb351ebda9ac8e6e1a5a8526a15552.png 0.0737082066869301 0.9454574115423517 '/tmp/doc-workspace-1220/62e03340f1aee-2.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e03340f1aee-3.pdf /tmp/doc-workspace-1220/fe91630765b0fda569d7ef3475c75bcf.png 0.10866261398176291 0.9236771531551609 '/tmp/doc-workspace-1220/62e03340f1aee-3.pdf'
echo "Proceso de separación de PDF"
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/4d065cca7af8b54689287e51d3c6d32a.pdf' '/tmp/doc-workspace-1220/62e033bc0c7f2-%d.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e033bc0c7f2-1.pdf /tmp/doc-workspace-1220/2cd85a268746878f6aa9ca83a3ff1897.png 0.07826747720364742 0.9308829490629883 '/tmp/doc-workspace-1220/62e033bc0c7f2-1.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e033bc0c7f2-2.pdf /tmp/doc-workspace-1220/c7619b7dc269f27b9e5a917509afc260.png 0.128419452887538 0.920097018271434 '/tmp/doc-workspace-1220/62e033bc0c7f2-2.pdf'
echo "Proceso de estampado de pdf1"
/bin/estampar /tmp/doc-workspace-1220/62e033bc0c7f2-3.pdf /tmp/doc-workspace-1220/efafe32a514b152aed0b50a0c85c806c.png 0.12537993920972645 0.9265148150975613 '/tmp/doc-workspace-1220/62e033bc0c7f2-3.pdf'
echo "Proceso de estampado de pdf2"
/bin/estampar /tmp/doc-workspace-1220/62e033bc0c7f2-4.pdf /tmp/doc-workspace-1220/d461ad2cefd890b63df02f50ef02fb52.png 0.11626139817629179 0.9060517875210612 '/tmp/doc-workspace-1220/62e033bc0c7f2-4.pdf'
echo "Proceso de estampado de pdf3"
/bin/estampar /tmp/doc-workspace-1220/62e033bc0c7f2-5.pdf /tmp/doc-workspace-1220/22d0af743de26e05d05bd86f989710a1.png 0.12689969604863222 0.9199962151799241 '/tmp/doc-workspace-1220/62e033bc0c7f2-5.pdf'
echo "Proceso de estampado de pdf4"
/bin/estampar /tmp/doc-workspace-1220/62e033bc0c7f2-6.pdf /tmp/doc-workspace-1220/11bfd0a9887802788621468ab99c6e05.png 0.11930091185410334 0.9049093524839495 '/tmp/doc-workspace-1220/62e033bc0c7f2-6.pdf'
echo "Proceso de estampado de pdf5"
/bin/estampar /tmp/doc-workspace-1220/62e033bc0c7f2-7.pdf /tmp/doc-workspace-1220/a938dbacdc3ee2d50c1eda194da2cda6.png 0.13297872340425532 0.9081014503817615 '/tmp/doc-workspace-1220/62e033bc0c7f2-7.pdf'
echo "Proceso de estampado de pdf6"
/bin/estampar /tmp/doc-workspace-1220/62e033bc0c7f2-8.pdf /tmp/doc-workspace-1220/40d4eb766a52b7b62859879161dc8279.png 0.10562310030395136 0.9069926163751532 '/tmp/doc-workspace-1220/62e033bc0c7f2-8.pdf'
echo "Proceso de estampado de pdf7"
/bin/estampar /tmp/doc-workspace-1220/62e033bc0c7f2-9.pdf /tmp/doc-workspace-1220/ff62bc48c30a9e7e891e23531e541e71.png 0.128419452887538 0.9026580834402295 '/tmp/doc-workspace-1220/62e033bc0c7f2-9.pdf'
echo "Proceso de estampado de pdf8"
/bin/estampar /tmp/doc-workspace-1220/62e033bc0c7f2-10.pdf /tmp/doc-workspace-1220/f92b85b14d9b0c960e790c41719f68ee.png 0.11322188449848024 0.9058501813380415 '/tmp/doc-workspace-1220/62e033bc0c7f2-10.pdf'
echo "Proceso de estampado de pdf9"
/bin/estampar /tmp/doc-workspace-1220/62e033bc0c7f2-11.pdf /tmp/doc-workspace-1220/1f326b4125087f7adbdcfb4811c442a8.png 0.1405775075987842 0.8746348240004903 '/tmp/doc-workspace-1220/62e033bc0c7f2-11.pdf'
echo "Proceso de separación de PDF9"
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/ANEXO-02.pdf' '/tmp/doc-workspace-1220/62e032f6c7057-%d.pdf'
echo "Proceso de estampado de pdf8"
/bin/estampar /tmp/doc-workspace-1220/62e032f6c7057-1.pdf /tmp/doc-workspace-1220/b7fc1edf16b75258fad65c9966714e46.png 0.10468 0.92624 '/tmp/doc-workspace-1220/62e032f6c7057-1.pdf'
echo "Proceso de estampado de pdf7"
/bin/estampar /tmp/doc-workspace-1220/62e032f6c7057-1.pdf /tmp/doc-workspace-1220/7a309f2392e814a032bf9528ccbe4b8c.png 0.45364741641337386 0.7050840240809177 '/tmp/doc-workspace-1220/62e032f6c7057-1.pdf'
echo "Proceso de separación de PDF6"
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/ANEXO-03.pdf' '/tmp/doc-workspace-1220/62e032f6c7072-%d.pdf'
echo "Proceso de estampado de pdf5"
/bin/estampar /tmp/doc-workspace-1220/62e032f6c7072-1.pdf /tmp/doc-workspace-1220/a1b7ef04ae2f53bc50f3e79db9e82640.png 0.16756 0.89385 '/tmp/doc-workspace-1220/62e032f6c7072-1.pdf'
echo "Proceso de estampado de pdf44"
/bin/estampar /tmp/doc-workspace-1220/62e032f6c7072-1.pdf /tmp/doc-workspace-1220/6937afd416191648b839d085c3f35120.png 0.43844984802431614 0.4857554774433354 '/tmp/doc-workspace-1220/62e032f6c7072-1.pdf'
echo "Proceso de separación de PDF3"
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/ANEXO-04.pdf' '/tmp/doc-workspace-1220/62e032f6c708e-%d.pdf'
echo "Proceso de estampado de pdf2"
/bin/estampar /tmp/doc-workspace-1220/62e032f6c708e-1.pdf /tmp/doc-workspace-1220/e9fb351ebda9ac8e6e1a5a8526a15552.png 0.16205 0.88233 '/tmp/doc-workspace-1220/62e032f6c708e-1.pdf'
echo "Proceso de estampado de pdf1111111"
/bin/estampar /tmp/doc-workspace-1220/62e032f6c708e-1.pdf /tmp/doc-workspace-1220/3a4b1af8c9bdd509ec691fed8d7a13c4.png 0.41717325227963525 0.5115420883820002 '/tmp/doc-workspace-1220/62e032f6c708e-1.pdf'
echo "Proceso de separación de PDF"
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/5c2f3b3c86cca32a282bc3f905bac590.pdf' '/tmp/doc-workspace-1220/62e05fc8aa041-%d.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e05fc8aa041-1.pdf /tmp/doc-workspace-1220/fe91630765b0fda569d7ef3475c75bcf.png 0.13297872340425532 0.9179801533497272 '/tmp/doc-workspace-1220/62e05fc8aa041-1.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e05fc8aa041-1.pdf /tmp/doc-workspace-1220/7e7c50e7118fdf3f9edce81a4a27720f.png 0.4749240121580547 0.5319715149279971 '/tmp/doc-workspace-1220/62e05fc8aa041-1.pdf'
echo "Proceso de separación de PDF"
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/e52fcb8396e766a8db031c7606b9a86d.pdf' '/tmp/doc-workspace-1220/62e044ed99352-%d.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e044ed99352-1.pdf /tmp/doc-workspace-1220/2cd85a268746878f6aa9ca83a3ff1897.png 0.09342379958246347 0.925733090508411 '/tmp/doc-workspace-1220/62e044ed99352-1.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e044ed99352-1.pdf /tmp/doc-workspace-1220/cc0350773dc9eca7cbc0dbad8808623a.png 0.6550104384133612 0.9021004946597719 '/tmp/doc-workspace-1220/62e044ed99352-1.pdf'
echo "Proceso de separación de PDF"
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/ANEXO-11.pdf' '/tmp/doc-workspace-1220/62e032f6c70da-%d.pdf'
echo "Proceso de estampado de pdf66666"
/bin/estampar /tmp/doc-workspace-1220/62e032f6c70da-1.pdf /tmp/doc-workspace-1220/c7619b7dc269f27b9e5a917509afc260.png 0.12503 0.89069 '/tmp/doc-workspace-1220/62e032f6c70da-1.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e032f6c70da-1.pdf /tmp/doc-workspace-1220/af5113ed0b0863429c93fc61cb323875.png 0.45972644376899696 0.47390893421832175 '/tmp/doc-workspace-1220/62e032f6c70da-1.pdf'
echo "Proceso de separación de PDF66666"
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/50c49c9bf811eaedd5992f951687fec7.pdf' '/tmp/doc-workspace-1220/62e058e94e646-%d.pdf'
echo "Proceso de estampado de pdf777"
/bin/estampar /tmp/doc-workspace-1220/62e058e94e646-1.pdf /tmp/doc-workspace-1220/efafe32a514b152aed0b50a0c85c806c.png 0.09650455927051672 0.9158296873975169 '/tmp/doc-workspace-1220/62e058e94e646-1.pdf'
echo "Proceso de estampado de pdf888"
/bin/estampar /tmp/doc-workspace-1220/62e058e94e646-1.pdf /tmp/doc-workspace-1220/3b5e6cda625c365327a64dc4ef5ddeb0.png 0.4749240121580547 0.6244415508730354 '/tmp/doc-workspace-1220/62e058e94e646-1.pdf'
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/4c8e50b6dd9ae55e2f0eaaf8d72e7a41.pdf' '/tmp/doc-workspace-1220/62e045075aaf4-%d.pdf'
echo "Proceso de estampado de pdf999"
/bin/estampar /tmp/doc-workspace-1220/62e045075aaf4-1.pdf /tmp/doc-workspace-1220/d461ad2cefd890b63df02f50ef02fb52.png 0.12537993920972645 0.9254517168669536 '/tmp/doc-workspace-1220/62e045075aaf4-1.pdf'
echo "Proceso de estampado de pdf000"
/bin/estampar /tmp/doc-workspace-1220/62e045075aaf4-2.pdf /tmp/doc-workspace-1220/22d0af743de26e05d05bd86f989710a1.png 0.15273556231003038 0.7615222086983354 '/tmp/doc-workspace-1220/62e045075aaf4-2.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e045075aaf4-4.pdf /tmp/doc-workspace-1220/11bfd0a9887802788621468ab99c6e05.png 0.16185410334346503 0.9233088474791284 '/tmp/doc-workspace-1220/62e045075aaf4-4.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e045075aaf4-21.pdf /tmp/doc-workspace-1220/a938dbacdc3ee2d50c1eda194da2cda6.png 0.12993920972644377 0.7979509882913617 '/tmp/doc-workspace-1220/62e045075aaf4-21.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e045075aaf4-22.pdf /tmp/doc-workspace-1220/40d4eb766a52b7b62859879161dc8279.png 0.11018237082066869 0.7775937291070235 '/tmp/doc-workspace-1220/62e045075aaf4-22.pdf'
echo "Proceso de separación de PDF"
/usr/bin/pdfseparate '/tmp/doc-workspace-1220/b8ee8d941c0dad633053ea2e7f1633b4.pdf' '/tmp/doc-workspace-1220/62e0566c5a501-%d.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e0566c5a501-1.pdf /tmp/doc-workspace-1220/ff62bc48c30a9e7e891e23531e541e71.png 0.13145896656534956 0.763146604790593 '/tmp/doc-workspace-1220/62e0566c5a501-1.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e045075aaf4-9.pdf /tmp/doc-workspace-1220/f92b85b14d9b0c960e790c41719f68ee.png 0.17857142857142858 0.8954515454374026 '/tmp/doc-workspace-1220/62e045075aaf4-9.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e045075aaf4-10.pdf /tmp/doc-workspace-1220/1f326b4125087f7adbdcfb4811c442a8.png 0.1952887537993921 0.8600942005382888 '/tmp/doc-workspace-1220/62e045075aaf4-10.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e045075aaf4-11.pdf /tmp/doc-workspace-1220/b7fc1edf16b75258fad65c9966714e46.png 0.2621580547112462 0.9340231944182539 '/tmp/doc-workspace-1220/62e045075aaf4-11.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e045075aaf4-13.pdf /tmp/doc-workspace-1220/a1b7ef04ae2f53bc50f3e79db9e82640.png 0.19072948328267478 0.9211659780913034 '/tmp/doc-workspace-1220/62e045075aaf4-13.pdf'
echo "Proceso de estampado de pdf"
/bin/estampar /tmp/doc-workspace-1220/62e045075aaf4-17.pdf /tmp/doc-workspace-1220/e9fb351ebda9ac8e6e1a5a8526a15552.png 0.15121580547112462 0.9415232372756416 '/tmp/doc-workspace-1220/62e045075aaf4-17.pdf'
echo "Uniendo los documento en PDF"
/usr/bin/convert -alpha remove -density 200 -quality 100 /tmp/doc-workspace-1220/38cc674004f16a2206b41294c5cdd8db.pdf /tmp/doc-workspace-1220/62e032f6c701d-1.pdf /tmp/doc-workspace-1220/62e03340f1aee-1.pdf /tmp/doc-workspace-1220/62e03340f1aee-2.pdf /tmp/doc-workspace-1220/62e03340f1aee-3.pdf /tmp/doc-workspace-1220/62e033bc0c7f2-1.pdf /tmp/doc-workspace-1220/62e033bc0c7f2-2.pdf /tmp/doc-workspace-1220/62e033bc0c7f2-3.pdf /tmp/doc-workspace-1220/62e033bc0c7f2-4.pdf /tmp/doc-workspace-1220/62e033bc0c7f2-5.pdf /tmp/doc-workspace-1220/62e033bc0c7f2-6.pdf /tmp/doc-workspace-1220/62e033bc0c7f2-7.pdf /tmp/doc-workspace-1220/62e033bc0c7f2-8.pdf /tmp/doc-workspace-1220/62e033bc0c7f2-9.pdf /tmp/doc-workspace-1220/62e033bc0c7f2-10.pdf /tmp/doc-workspace-1220/62e033bc0c7f2-11.pdf /tmp/doc-workspace-1220/62e032f6c7057-1.pdf /tmp/doc-workspace-1220/62e032f6c7072-1.pdf /tmp/doc-workspace-1220/62e032f6c708e-1.pdf /tmp/doc-workspace-1220/62e05fc8aa041-1.pdf /tmp/doc-workspace-1220/62e044ed99352-1.pdf /tmp/doc-workspace-1220/62e032f6c70da-1.pdf /tmp/doc-workspace-1220/62e058e94e646-1.pdf /tmp/doc-workspace-1220/83f97411246a1e73a69884c4def76272.pdf /tmp/doc-workspace-1220/62e045075aaf4-1.pdf /tmp/doc-workspace-1220/62e045075aaf4-2.pdf /tmp/doc-workspace-1220/62e045075aaf4-4.pdf /tmp/doc-workspace-1220/62e045075aaf4-21.pdf /tmp/doc-workspace-1220/62e045075aaf4-22.pdf /tmp/doc-workspace-1220/62e0566c5a501-1.pdf /tmp/doc-workspace-1220/62e045075aaf4-9.pdf /tmp/doc-workspace-1220/62e045075aaf4-10.pdf /tmp/doc-workspace-1220/62e045075aaf4-11.pdf /tmp/doc-workspace-1220/62e045075aaf4-13.pdf /tmp/doc-workspace-1220/62e045075aaf4-17.pdf /tmp/doc-workspace-1220/a861908961fb5432f4a5254d710a50b7.pdf /tmp/doc-workspace-1220/b9284417074bbd58a44ff95655c9bd9e.pdf /tmp/doc-workspace-1220/Propuesta.pdf
/bin/cp /tmp/doc-workspace-1220/Propuesta.pdf /tmp/doc-workspace-1220/Propuesta_Seace.pdf
/snap/bin/gsutil cp '/tmp/doc-workspace-1220/Propuesta_Seace.pdf' 'gs://creainter-peru/storage/tenant-1/2022_07_26-62e0319e82f8b.pdf'
echo "Escaneando documento..."
/usr/bin/convert -density 140 /tmp/doc-workspace-1220/Propuesta.pdf -rotate 0.5 -attenuate 0.1 +noise Multiplicative -attenuate 0.01 +noise Multiplicative -sharpen 0x1.0 /tmp/doc-workspace-1220/Propuesta_Seace.pdf
echo "Proceso de foliación de PDF"
/bin/pdf-foliar /tmp/doc-workspace-1220/Propuesta_Seace.pdf
/snap/bin/gsutil cp '/tmp/doc-workspace-1220/Propuesta_Seace.pdf' 'gs://creainter-peru/storage/tenant-1/2022_07_26-62e0319e82f73.pdf'
echo "Eliminando directorio de trabajo: /tmp/doc-workspace-1220/"
/bin/rm -rf '/tmp/doc-workspace-1220/'
echo "Finalizó el proceso"
sleep 5
