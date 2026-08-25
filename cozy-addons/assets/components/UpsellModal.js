import { Modal, Button } from "@wordpress/components";

import { memo, useState } from "@wordpress/element";

import { dispatch } from "@wordpress/data";

export const UpsellModal = memo(({ blockName, blockDescription, clientId }) => {
	const [isOpen, setOpen] = useState(true);
	const closeModal = () => {
		dispatch("core/editor").removeBlocks(clientId, false);
		setOpen(false);
	};

	return (
		<>
			{isOpen && (
				<Modal
					title={`${blockName} is available in Pro`}
					onRequestClose={closeModal}
					size="medium"
				>
					{blockDescription && <p>{blockDescription}</p>}

					<p>Upgrade to Cozy Blocks Pro to import this block.</p>

					<div style={{ textAlign: "right" }}>
						<Button
							variant="tertiary"
							onClick={closeModal}
							style={{ marginRight: "12px" }}
						>
							Not now
						</Button>
						<Button
							href="https://cozythemes.com/pricing-and-plans"
							target="_blank"
							variant="primary"
						>
							Upgrade to Pro
						</Button>
					</div>
				</Modal>
			)}
		</>
	);
});
