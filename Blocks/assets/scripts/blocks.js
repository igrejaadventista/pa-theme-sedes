(function(data) {
  data.subscribe(() => {
    const editor = wp.data.select("core/editor");
    if (!editor) return;

    const blocks = wp.data.select("core/block-editor").getBlocks();

    if (!blocks.length) return;

    blocks.forEach(block => {
      if (block.attributes.name != "acf/p-a-row") return;

      const innerBlocks = block.innerBlocks;

      if (!innerBlocks.length) return;

      innerBlocks.forEach(innerBlock => {
        const $blockElement = document.getElementById(
          `block-${innerBlock.clientId}`
        );

        if (!$blockElement) return;

        $blockElement.setAttribute(
          "data-width",
          $blockElement.offsetWidth < 565 ? "block-compact" : ""
        );

        if (!innerBlock.attributes.hasOwnProperty("data")) return;

        let format = null;

        if (innerBlock.attributes.data.hasOwnProperty("block_format"))
          format = innerBlock.attributes.data.block_format;
        else {
          Object.keys(innerBlock.attributes.data).forEach(function(key) {
            const field = acf.getField(key);

            if (field.data.name == "block_format")
              format = innerBlock.attributes.data[key];
          });
        }

        if (!format) return;

        $blockElement.dataset.format = format;
      });
    });
  });
})(wp.data);
