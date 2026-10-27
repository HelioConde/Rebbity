import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'
const read = path => readFileSync(new URL('../'+path, import.meta.url),'utf8')
test('alteracoes destrutivas exigem proprietario e prepared statements',()=>{
 for(const file of ['portal/categoryChageDel.php','portal/categoryChageName.php','portal/categoryChageDelItem.php','portal/categorySubDelItem.php']){
  const source=read(file);
  assert.match(source,/id_client = \?/);
  assert.match(source,/mysqli_stmt_bind_param/);
  assert.match(source,/require_partner_session/);
 }
})
test('uploads sao validados pela assinatura MIME, com limite',()=>{
 const source=read('portal/image-upload.php');
 assert.match(source,/finfo\(FILEINFO_MIME_TYPE\)/);
 assert.match(source,/is_uploaded_file/);
 assert.match(source,/2 \* 1024 \* 1024/);
 assert.match(source,/getimagesize/);
})
test('novos itens respeitam o dono e a transacao da subcategoria',()=>{
 assert.match(read('portal/newItemCategory.php'),/id_client = \?/);
 assert.match(read('portal/insertSubCategory.php'),/mysqli_begin_transaction/);
 assert.match(read('portal/insertSubCategory.php'),/mysqli_rollback/);
})
test('nomes de categoria sao escapados antes de entrar no HTML',()=>{
 assert.match(read('portal/viewCategory.php'),/htmlspecialchars/);
 assert.match(read('portal/viewCategory.php'),/JSON_HEX_TAG/);
})
