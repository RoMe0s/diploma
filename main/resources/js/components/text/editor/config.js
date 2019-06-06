export default {
  vueIgnoreAttrs: ['class', 'id', 'fr-original-style'],
  heightMin: 500,
  toolbarButtons: {
    moreText: {
      buttons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'clearFormatting', 'backgroundColor'],
      buttonsVisible: 2
    },
    moreParagraph: {
      buttons: ['alignLeft', 'alignCenter', 'alignRight', 'paragraphFormat', 'alignJustify', 'formatOL', 'formatUL', 'quote'],
      buttonsVisible: 4
    },
    moreRich: {
      buttons: ['insertTable', 'insertLink', 'insertImage', 'insertVideo'],
      buttonsVisible: 5
    },
    moreMisc: {
      buttons: ['undo', 'redo', 'fullscreen'],
      buttonsVisible: 3,
      align: 'right'
    }
  },
  htmlExecuteScripts: false,

  tableCellStyles: null,
  tableInsertHelper: false,
  tableEditButtons: ['tableHeader', 'tableRemove', 'tableRows', 'tableColumns', 'tableCellVerticalAlign', 'tableCellHorizontalAlign'],

  videoUpload: false,
  videoInsertButtons: ['videoByURL'],
  videoDefaultWidth: 0,

  imageInsertButtons: ['imageByURL'],
  imageEditButtons: ['imageRemove', 'imageAlt', 'imageSize'],
  imagePaste: false,
  imageUpload: false,
  imageDefaultMargin: 0,
  imageDefaultWidth: 0,

  useClasses: false,
  htmlAllowedAttrs: [
    'style',
    'target',
    'href',
    'rel',
    'src',
    'alt'
  ],
  paragraphFormatSelection: true,
  paragraphFormat: {
    N: 'Normal',
    H2: 'Heading 2',
    H3: 'Heading 3',
    H4: 'Heading 4',
    H5: 'Heading 5',
    H6: 'Heading 6'
  },
  htmlAllowedEmptyTags: [
    'iframe'
  ],
  listAdvancedTypes: false,
  pluginsEnabled: [
    'colors',
    'align',
    'lists',
    'charCounter',
    'fullscreen',
    'paragraphFormat',
    'quote',
    'url',
    'image',
    'video',
    'table',
    'lineBreaker'
  ],
  htmlAllowedStyleProps: [
    'background-color',
    'vertical-align',
    'text-align',
    'float',
    'display',
    'margin',
    'height',
    'width'
  ],
  htmlAllowedTags: [
    'a',
    'blockquote',
    'em',
    'h2',
    'h3',
    'h4',
    'h5',
    'h6',
    'hr',
    'iframe',
    'img',
    'li',
    'ol',
    'p',
    's',
    'span',
    'strong',
    'sub',
    'sup',
    'table',
    'tbody',
    'td',
    'thead',
    'tr',
    'u',
    'ul',
    'br'
  ]
}