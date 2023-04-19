import { addFilter } from "@wordpress/hooks";
import { BlockControls } from "@wordpress/block-editor";
import { ToolbarButton } from "@wordpress/components";
import { select } from "@wordpress/data";

import { __ } from "@wordpress/i18n";

const label = __("Footnote", "hfh-footnotes");
const promptLabel = __("Enter footnote content:", "hfh-footnotes");

const Footnote = (BlockEdit) => {
  return (props) => {
    if (props.name !== "core/paragraph") {
      return <BlockEdit {...props} />;
    }

    return (
      <>
        <BlockEdit {...props} />
        <BlockControls>
          <ToolbarButton
            icon="testimonial"
            label={label}
            onClick={() => {
              const currentContent = props.attributes.content || "";
              const selectionEnd =
                select("core/block-editor").getSelectionEnd();
              const position = selectionEnd.offset;
              const footnoteContent = prompt(promptLabel);
              if (!footnoteContent) {
                return;
              }
              const footnoteShortcode = `[hfh_footnote]${footnoteContent}[/hfh_footnote]`;
              props.setAttributes({
                content: [
                  currentContent.slice(0, position),
                  footnoteShortcode,
                  currentContent.slice(position),
                ].join(""),
              });
            }}
          />
        </BlockControls>
      </>
    );
  };
};

addFilter("editor.BlockEdit", "hfh", Footnote);
