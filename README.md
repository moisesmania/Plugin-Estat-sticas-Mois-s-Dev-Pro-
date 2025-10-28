# 📊 Plugin Estatísticas Moisés Dev Pro+

**Versão:** 3.0  
**Autor:** Moisés Dev Pro+  
**Licença:** GPL2  
**Compatível com:** Gutenberg, tema Blocksy, Tainacan e todo o banco de dados WordPress.

---

## 🧩 Descrição

O **Estatísticas Moisés Dev Pro+** é um plugin WordPress que exibe estatísticas dinâmicas sobre o conteúdo do seu site — incluindo **acessos, músicas, vídeos e acervos/documentos**.  
Ele atualiza automaticamente os números conforme novos conteúdos são adicionados ou removidos, integrando-se tanto com **Tainacan** quanto com **qualquer tipo de mídia ou post** do banco de dados.

---

## ⚙️ Funcionalidades

✅ Conta **músicas e áudios** (`audio`, `musica`, `attachment audio`)  
✅ Conta **vídeos** (`video`, `attachment video`)  
✅ Conta **acervos e documentos** (Tainacan, PDFs, DOCX, XLSX, ODT, etc.)  
✅ Registra **acessos por usuário e visitante**, semanalmente  
✅ Disponível como **shortcode** e **bloco Gutenberg**  
✅ Atualização **automática** de todos os números  
✅ Layout moderno com CSS responsivo  

---

## 📦 Instalação

1. Crie uma pasta chamada `moises-estatisticas-proplus` dentro de `/wp-content/plugins/`.  
2. Salve o código do plugin como `moises-estatisticas-proplus.php`.  
3. Compacte a pasta em `.zip`.  
4. No WordPress:  
   - Vá em **Plugins → Adicionar Novo → Enviar Plugin**  
   - Escolha o arquivo `.zip` e clique em **Instalar Agora**  
   - Depois, clique em **Ativar**.

---

## 💡 Como Usar

### 🔹 Shortcode
Adicione o shortcode abaixo em qualquer página, post ou widget:

```
[estatisticas_site]
```

### 🔹 Bloco Gutenberg
1. No editor de blocos (Gutenberg), clique em **Adicionar Bloco**.  
2. Procure por **“Estatísticas Moisés Dev Pro+”**.  
3. Insira o bloco onde desejar.

---

## 📊 Exemplo de Exibição

```
📊 Estatísticas do Site
Acessos: 100        Vídeos: 80
Acervos: 70         Músicas: 300
💡 Plugin desenvolvido por Moisés Dev Pro+
```

---

## 🧠 Como Funciona o Código

### 🔢 `mdp_get_counts_db()`
Conta todos os conteúdos do site:
- Áudios e músicas
- Vídeos
- Acervos do Tainacan
- Documentos anexados (PDF, DOCX, XLSX, ODT, etc.)

### 👥 `mdp_contar_acessos()`
Registra os acessos de cada visitante ou usuário logado, contando por semana.  
Os dados ficam armazenados no banco de dados (`user_meta` e `wp_options`).

### 📊 `mdp_render_estatisticas()`
Renderiza a interface visual das estatísticas, usada tanto pelo shortcode quanto pelo bloco Gutenberg.

### 🧱 `mdp_register_block()`
Registra o bloco “Estatísticas Moisés Dev Pro+” no editor Gutenberg.

### 🎨 CSS Inline
Adiciona o estilo visual do bloco diretamente no site, sem precisar de arquivos CSS externos.

---

## 🧭 Compatibilidade

- WordPress 6.0+  
- Tema **Blocksy**  
- Editor **Gutenberg**  
- Plugin **Tainacan** (para acervos)

---

## 🧑‍💻 Créditos

💡 **Plugin desenvolvido por [Moisés Dev Pro+]**
